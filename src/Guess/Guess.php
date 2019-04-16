<?php

namespace Tuss\Guess;

/**
 * Guess my number, a class supporting the game through GET, POST and SESSION.
 */
class Guess
{
    /**
     * @var int $secretNo   The current secret number.
     * @var int $try    Number of tries a guess has been made.
     */
    protected $secretNo;
    protected $try;


    /**
     * Constructor to initiate the object with current game settings,
     * if available. Randomize the current number if no value is sent in.
     *
     * @param int $secretNo   The current secret number, default 101 to initiate
     *                        the number from start.
     * @param int $try        Number of tries a guess has been made,
     *                        default 6.
     */
    public function __construct(int $secretNo = 101, int $try = 6)
    {
        if ($secretNo === 101) {
            $this->secretNo = rand(1, 100);
            $this->try = $try;
        } else {
            $this->secretNo = $secretNo;
            $this->try = $try;
        }
    }

    /**
     * Randomize the secret number between 1 and 100 to initiate a new game.
     *
     * @return void
     */

    public function random()
    {
        $this->secretNo = rand(1, 100);
    }




    /**
     * Get number of tries left.
     *
     * @return int as number of tries made.
     */

    public function getTry()
    {
        return $this->try;
    }



    /**
     * Get the secret number.
     *
     * @return int as the secret number.
     */

    public function getSecretNo()
    {
        return $this->secretNo;
    }




    /**
     * Make a guess, decrease remaining guesses and return a string stating
     * if the guess was correct, too low or to high.
     *
     * @throws GuessException when guessed number is out of bounds.
     *
     * @return string to show the status of the guess made.
     */

    public function makeGuess($guess)
    {
        if (!(is_int($guess) && $guess <= 100 && $guess > 0)) {
            throw new GuessException("Du måste gissa på ett nummer mellan
            1 och 100.");
        }

        if ($this->secretNo === $guess) {
            $res = "Rätt gissat!";
            $this->try -= 1;
        } elseif ($this->secretNo > $guess) {
            $this->try -= 1;
            $res = "Numret är högre";
        } else {
            $res = "Numret är lägre";
            $this->try -= 1;
        }

        if ($this->secretNo === $guess && $this->try === 0) {
            $res = "Rätt gissat!";
        } elseif ($this->try === 0) {
            $res = "Game Over! Bättre lycka nästa gång!";
        }
            return $res;
    }
}
