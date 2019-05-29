<?php

namespace Tuss\Dice100;

// use Anax\Route\Exception\ForbiddenException;
// use Anax\Route\Exception\NotFoundException;
// use Anax\Route\Exception\InternalErrorException;

/**
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 * Dice100 A game of dice-throwing
 */
class Dice100 implements HistogramInterface
{
    use HistogramTrait2;
    /**
     * constructor to initiate
     * set values to starting amount and choose who starts,
     * player or computer
     *
     * @param int $quantity         Number of dices in the game
     * @param int $playerPoints     All saved player points
     * @param int $computerPoints   All saved computer points
     * @param int $currentPLayer    0 and 1 to indentify current player
     * @var       $hand             the dicehand object currently used
     * @var       $turn             the diceturn object currently used
     */

    protected $quantity;
    protected $playerPoints;
    protected $computerPoints;
    protected $currentPlayer;
    protected $hand;
    protected $turn;
    protected $histogram;

    public function __construct(int $quantity = 3)
    {
        $this->quantity = $quantity;
        $this->playerPoints = 0;
        $this->computerPoints = 0;
        $this->currentPlayer = rand(0, 1);
        $this->serie = [];
        $this->histogram = new Histogram();
    }

    /**
     * check to see who is the current player and then change it
     *
     * @return void
     */
    public function changePlayer()
    {
        if ($this->currentPlayer === 0) {
            $this->currentPlayer = 1;
        } else if ($this->currentPlayer === 1) {
            $this->currentPlayer = 0;
        }
    }

    /**
     * create a new turn
     *
     * @return void
     */
    public function newTurn()
    {
        $this->turn = new DiceTurn();
    }

    /**
     * return who is currently playing
     *
     * @return int
     */
    public function currentlyPlaying()
    {
        return $this->currentPlayer;
    }

    /**
     * create new hand when PLAYER plays
     * add graphic for the throw
     * get total points from current hand and save in DiceTurn
     * look for number one in the result
     * return boolean about the presence of number one
     * if one is found then the points will be set to 0
     *
     * @return boolean
     */
    public function playerPlays()
    {
        $this->hand = new DiceHand($this->quantity);
        $this->turn->addHand($this->hand->graphic());
        $this->turn->addPoints($this->hand->sum());
        $thereIsOne = $this->hand->lookForOne();

        if ($thereIsOne === true) {
            $this->turn->resetPoints();
        }
        return $thereIsOne;
    }

    /**
     * adding upp the values from each dice hand in $this->serie to get all
     * throws that is made during the entire game to be able to constantly
     * update the histogram. Use current class as object to pass into
     * Histogram method
     *
     * @return void
     */
    public function createHistogram()
    {
        for ($i=0; $i<count($this->hand->getHandSerie()); $i++) {
            array_push($this->serie, $this->hand->getHandSerie()[$i]);
        }

        $this->histogram->injectData($this);
        $this->str = $this->histogram->getAsText();
    }

    /**
     * create new hand when COMPUTER plays
     * add graphic for the throw
     * get total points from current hand and save in DiceTurn
     * look for number one in the result
     * return boolean about the presence of number one
     * if one is found then the points will be set to 0
     * save result if thereIsOne is false.
     * returns dice-graphic to show in view
     *
     * @return string
     */
    public function computerPlays()
    {
        $graphic = [];
        $throws;

        if ($this->computerPoints < ($this->playerPoints - 10)) {
            $throws = 3;
        } else if ($this->computerPoints > ($this->playerPoints + 10)) {
            $throws = 1;
        } else {
            $throws = 2;
        }

        for ($i=0; $i<$throws; $i++) {
            $this->hand = new DiceHand($this->quantity);
            $this->turn->addHand($this->hand->graphic());
            $this->turn->addPoints($this->hand->sum());
            $thereIsOne = $this->hand->lookForOne();
            array_push($graphic, $this->hand->graphic());

            if ($thereIsOne === true) {
                $this->turn->resetPoints();
                break 1;
            }
        }

        if ($thereIsOne === false) {
            $this->computerPoints += $this->turn->getPoints();
        }

        return $graphic;
    }

    /**
     * return computer points
     *
     * @return int
     */
    public function returnComputerPoints()
    {
        return $this->computerPoints;
    }

    /**
     * return player points
     *
     * @return int
     */
    public function returnPlayerPoints()
    {
        return $this->playerPoints;
    }

    /**
     * saves the players points from current turn
     *
     * @return void
     */
    public function savePlayerScore()
    {
        $this->playerPoints += $this->turn->getPoints();
    }

    /**
     * return who is playing as a string to use in view
     *
     * @return string
     */
    public function playerName()
    {
        $playerName = "Datorn";
        if ($this->currentPlayer === 0) {
            $playerName = "Du";
        }
        return $playerName;
    }

    /**
     * return data to use in view
     *
     * @return mixed
     */
    public function getGameStatistics()
    {
        $data = [
            "currentPlayer" => $this->playerName(),
            "turnPoints" => $this->turn->getPoints(),
            "computerPoints" => $this->computerPoints,
            "dicePics" => $this->turn->getTurnHands(),
            "playerPoints" => $this->playerPoints,
            "histoGram" => $this->str
        ];
        return $data;
    }
}
