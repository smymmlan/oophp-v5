<?php
namespace Tuss\Dice100;

/**
 * a dicehand, consisting of dices.
 */
class DiceHand extends Dice implements HistogramInterface
{

    use HistogramTrait2;

    /**
     * @var Dice $dices   Array consisting of dices.
     * @var int  $values  Array consisting of last roll of the dices.
     */
    protected $dices;
    protected $values;
    protected $thereIsOne;

    /**
     * constructor to initiate the dicehand with a number of dices.
     *
     * @param int $dices Number of dices to create, defaults to five.
     */
    public function __construct(int $dices = 5)
    {
        $this->dices  = [];
        $this->values = [];
        $this->thereIsOne = false;

        for ($i = 0; $i < $dices; $i++) {
            $this->dices[]  = new Dice();
            $this->values[] = rand(1, $this->dices[$i]->sides);
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
    * search the array of values for the number one.
    * if any of the dices shows one -return true.
    *
    * @param boolean $thereIsOne
    *
    * @return boolean
    */
    public function lookForOne()
    {
        $eyes = [];
        $eyes = $this->values();
        $j = count($eyes);

        for ($i=0; $i<$j; $i++) {
            if ($eyes[$i] == 1) {
                $this->thereIsOne = true;
                break;
            }
        }

        return $this->thereIsOne;
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

    /**
     * use current values and save in array serie to be used
     * in histogram
     *
     * @return array of integers
     */
    public function getHandSerie()
    {
        for($i = 0;$i < count($this->values);$i++){
            $this->serie[$i] = $this->values[$i];
        }

        return $this->serie;
    }
}
