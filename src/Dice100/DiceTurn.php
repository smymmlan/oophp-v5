<?php

namespace Tuss\Dice100;

/**
 * DiceTurn
 */
class DiceTurn
{
    /**
     * constructor to initiate the turn
     *
     * set/empty values/array to 0
     *
     * @param int $points             the points from the current turn
     * @param array $allHandsInTurn   collects all thrown hands
     */

    protected $points;
    protected $allHandsInTurn;


    public function __construct()
    {
        $this->points = 0;
        $this->allHandsInTurn = [];
    }

    /**
     * returns the points
     *
     * @param int $points             the points from the current turn
     * @return int
     */
    public function getPoints()
    {
        return $this->points;
    }

    /**
     * resets the points to 0
     *
     * @param int $points             the points from the current turn
     * @return void
     */
    public function resetPoints()
    {
        $this->points = 0;
    }

    /**
     * returns all thrown hands collected in an array
     *
     * @param array $allHandsInTurn   collects all thrown hands
     * @return array
     */
    public function getTurnHands()
    {
        return $this->allHandsInTurn;
    }

    /**
     * returns the dice graphic as string to use in view
     *
     * @return string
     */
    public function getGraphic()
    {
        return $this->diceHand->graphic();
    }

    /**
     * pushes in the last hands graphics in array to collect all hands
     *
     * @return void
     */
    public function addHand($hand)
    {
        array_push($this->allHandsInTurn, $hand);
    }

    /**
     * adds the sum of last thrown hand to existing points.
     *
     * @return void
     */
    public function addPoints($hand)
    {
        $this->points = $this->points + $hand;
    }

    /**
     * returns all hands graphic
     *
     * @param array $allHandsInTurn   collects graphic of all thrown hands
     * @return array of strings
     */
    public function returnAllHandsInTurn()
    {
        return $this->allHandsInTurn;
    }
}
