<?php

namespace Tuss\Dice100;

/**
 * DiceTurn
 */
class DiceTurn extends DiceHand
{
    /**
     * constructor to initiate the turn
     *
     * @param int $points
     */

    protected $points;
    protected $quantity;
    protected $status;
    protected $diceHand;
    // protected $turn;

    public function __construct(int $quantity)
    {
        $this->quantity = $quantity;
        $this->points = 0;
        $this->status = "";
    }

    public function setPoints()
    {
        if ($this->status === "green") {
            $this->points += $this->diceHand->sum();
        }
    }

    public function throw()
    {
        $this->diceHand  = new DiceHand($this->quantity);
        $this->diceHand->roll();
    }

    public function getPoints()
    {
        return $this->points;
    }

    public function getGraphic()
    {
        return $this->diceHand->graphic();
    }

    public function lookForOne()
    {
        $eyes = [];
        $eyes = $this->diceHand->values();
        $j = count($eyes);
        $red = "";

        for ($i=0; $i<$j; $i++) {
            if ($eyes[$i] == 1) {
                $red = "red";
                break;
            }
        }

        if ($red === "red") {
            return "red";
        } else {
            return "green";
        }
    }

    public function setStatus()
    {
        $this->status = $this->lookForOne();
        $this->setPoints();
    }

    public function returnStatus()
    {
        return $this->status;
    }

}
