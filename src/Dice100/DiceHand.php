<?php
namespace Tuss\Dice100;

/**
 * a dicehand, consisting of dices.
 */
class DiceHand extends Dice
{
    /**
     * @var Dice $dices   Array consisting of dices.
     * @var int  $values  Array consisting of last roll of the dices.
     */
    private $dices;
    private $values;

    /**
     * constructor to initiate the dicehand with a number of dices.
     *
     * @param int $dices Number of dices to create, defaults to five.
     */
    public function __construct(int $dices = 5)
    {
        $this->dices  = [];
        $this->values = [];

        for ($i = 0; $i < $dices; $i++) {
            $this->dices[]  = new Dice();
            $this->values[] = null;
        }
    }

    /**
     * roll all dices save their value.
     *
     * @return void.
     */
    public function roll()
    {
         $j = count($this->dices);

        for ($i=0; $i<$j; $i++) {
            $this->values[$i] = rand(1, $this->dices[0]->sides);
        }
    }

     /**
     * get values of dices from last roll.
     *
     * @return array with values of the last roll.
     */
    public function values()
    {
        return $this->values;
    }

    /**
     * Get a graphic value of the last rolled dice.
     *
     * @return string as graphical representation of last rolled dice.
     */
    public function graphic()
    {

        $j = count($this->values);

        for ($i=0; $i<$j; $i++) {
            $str[$i] = "dice-" . $this->values[$i];
        }
        return $str;
    }

    /**
     * get the sum of all dices.
     *
     * @return int as the sum of all dices.
     */
    public function sum()
    {
        return array_sum($this->values);
    }

    /**
     * get the average of all dices.
     *
     * @return float as the average of all dices.
     */
    public function average()
    {
        $result = ($this->sum()) / (count($this->values));
        return number_format($result, 1);
    }
}
