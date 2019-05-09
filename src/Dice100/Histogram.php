<?php

namespace Tuss\Dice100;

/**
 * Generating histogram data.
 */
class Histogram
{
    /**
     * @var array $serie  The numbers stored in sequence.
     * @var int   $min    The lowest possible number.
     * @var int   $max    The highest possible number.
     */
    private $serie = [];
    private $min;
    private $max;



    /**
     * Get the serie.
     *
     * @return array with the serie.
     */
    public function getSerie()
    {
        return $this->serie;
    }



    /**
     * Return a string with a textual representation of the histogram.
     *
     * @return string representing the histogram.
     */
    public function getAsText()
    {
        $str = "";
        $cnt = [];
        $res = [];

        $cnt = array_count_values($this->serie);

        if (is_null($this->min) || is_null($this->max)) {
            for ($i=1; $i<6 + 1; $i++) {
                $res[$i] = "";
                if (isset($cnt[$i])) {
                    for ($j=0; $j<$cnt["$i"]; $j++) {
                        $res[(string)$i] .= "*";
                    }
                    $str .= "<p> " . $i . ": " . $res[$i]  . "</p>";
                } else {
                    $res[$i] = "";
                }
            }
        } else {
            for ($this->min; $this->min < $this->max + 1; $this->min++) {
                $res[(string)$this->min] = "";
                if (isset($cnt[$this->min])) {
                    for ($j=0; $j<$cnt["$this->min"]; $j++) {
                        $res[(string)$this->min] .= "*";
                    }
                } else {
                    $res[$this->min] = "";
                }
                $str .= "<p> " . $this->min . ": " . $res[$this->min]  . "</p>";
            }
        }
        return $str;
    }


    /**
     * Inject the object to use as base for the histogram data.
     *
     * @param HistogramInterface $object The object holding the serie.
     *
     * @return void.
     */
    public function injectData(HistogramInterface $object)
    {
        $this->serie = $object->getHistogramSerie();
        $this->min   = $object->getHistogramMin();
        $this->max   = $object->getHistogramMax();
    }
}
