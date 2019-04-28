<?php

namespace Tuss\Dice100;

/**
 * Dice100 A game of dice-throwing
 */
class Dice100 extends DiceTurn
{
    /**
     * constructor to initiate
     *
     * @param int $
     */

     protected $playerPoints;
     protected $computerPoints;
     protected $player;
     protected $computer;
     protected $quantity;
     protected $str;
     protected $compGraph;
     protected $getAllGraph = [];
     protected $status;
     protected $turn;
     protected $counter;

    public function __construct(int $quantity)
    {
        $this->str = "";
        $this->counter = 0;
        $this->computerPoints = 0;
        $this->playerPoints = 0;
        $randNr = rand(1, 2);
        $this->quantity = $quantity;

        if ($randNr == 1) {
            $this->str = "Du får börja";
        } else {
            $this->computerPlays();
            $this->str = "Datorn började";
        }

    }

    public function computerPlays()
    {
        $this->turn = new DiceTurn($this->quantity);
        $this->getAllGraph = array();
        $this->computerRoll();
    }

    public function computerRoll()
    {

        if ($this->counter == 2) {
            $this->counter = 0;
            $this->computerPoints = $this->getPoints();
            $this->endTurn();
        } else {
            $this->throw();
            $this->setStatus();
            array_push($this->getAllGraph,$this->getGraphic());
            $this->counter = $this->counter + 1;
            $this->controlComputerStatus();
        }
    }

    public function controlComputerStatus()
    {
        $this->status = $this->returnStatus();

        if ($this->status == "red") {
            $this->endTurn();
        } else if ($this->computerPoints >= 100) {
            $this->str = "Game Over! Datorn vann.";
        } else {
            $this->computerRoll();
        }
    }

    public function endTurn()
    {
        return "players turn";
    }

    public function returnStr()
    {
        return $this->str;
    }

    public function returnStatus()
    {
        return $this->status;
    }

    public function savePlayerPoints(int $points)
    {
        $this->playerPoints += $points;
    }

    public function returnCompGraph()
    {
        return $this->compGraph;
    }

    public function returnGetAllGraph()
    {

        return $this->getAllGraph;
    }

    public function returnComputerPoints()
    {
        return $this->computerPoints;
    }

    public function returnPlayerPoints()
    {
        return $this->playerPoints;
    }

    public function destroy()
    {
        unset($this->turn);
    }


}
