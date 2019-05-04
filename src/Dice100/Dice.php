<?php
namespace Tuss\Dice100;

/**
 * throwing dice
 *
 */
class Dice
{
    /**
    * @param int    $sides    the faces of the die
    * @param int    $result   the result of the roll
    * @var array  $lastRoll the results of last roll
    *
    */
    protected $sides;
    protected $result;
    protected $lastRoll = [];

    /**
     * Constructor to create a dice.
     *
     */
    public function __construct(int $sides = 6)
    {
        $this->sides = $sides;
        $this->result = null;
    }

    public function rollDice()
    {

        $this->result = rand(1, $this->sides);
        $this->lastRoll[]= $this->result;

        return $this->result;
    }

    public function getLastRoll()
    {
        return $this->lastRoll;
    }

    public function getSides()
    {
        return $this->sides;
    }
}
