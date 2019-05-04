<?php

namespace Tuss\Dice100;

use PHPUnit\Framework\TestCase;

/**
 * Example test class.
 */
class DiceHandTest extends TestCase
{
    /**
     * Just assert something is true.
     */
    public function testCreateObjectDiceHand()
    {
        $diceHand = new DiceHand(3);
        $this->assertInstanceOf("\Tuss\Dice100\DiceHand", $diceHand);

        $values = $diceHand->values();
        $valuesCount = count($values);
        $exp = 3;
        $this->assertEquals($exp, $valuesCount);
    }

    /**
     * Test if the return value is a string that contains the word "dice-"
     */
    public function testIfStringContainceDiceString()
    {
        $diceHand = new DiceHand(3);
        $this->assertInstanceOf("\Tuss\Dice100\DiceHand", $diceHand);

        $str = $diceHand->graphic();

        $this->assertRegExp('/dice-/', $str[0]);
    }

    /**
     * Test to see if method returns correct boolean after values are tested
     */
    public function testIfReturnsBoolean()
    {
        for ($i=0; $i<20; $i++) {
            $diceHand = new DiceHand(3);
            $this->assertInstanceOf("\Tuss\Dice100\DiceHand", $diceHand);
            $bol = "";

            $values = $diceHand->values();

            foreach ($values as $value) {
                if ($value == 1) {
                    $bol = true ;
                    break;
                } else {
                    $bol = false;
                }
            }

            $res = $diceHand->lookForOne();
            $this->assertEquals($bol, $res);
        }
    }

    /**
     * Test to see if method returns sum of values
     */
    public function testIfMethodSumReturnsSumOfValues()
    {
        $diceHand = new DiceHand(3);
        $this->assertInstanceOf("\Tuss\Dice100\DiceHand", $diceHand);

        $values = $diceHand->values();
        $exp= array_sum($values);
        $res = $diceHand->sum();

        $this->assertEquals($exp, $res);
    }

    /**
     * Test to see if method returns avarage
     */
    public function testIfMethodAvarageReturnsAvarageOfValues()
    {
        $diceHand = new DiceHand(3);
        $this->assertInstanceOf("\Tuss\Dice100\DiceHand", $diceHand);

        $values = $diceHand->values();
        $valSum = array_sum($values);
        $exp = $valSum / count($values);
        $exp = number_format($exp, 1);

        $res = $diceHand->average();

        $this->assertEquals($exp, $res);
    }

    /**
     * Test to see if values is integer
     */
    public function testIffValuesIsOfTypeInt()
    {
        $diceHand = new DiceHand();
        $this->assertInstanceOf("\Tuss\Dice100\DiceHand", $diceHand);

        $values = $diceHand->values();
        $values = end($values);
        $this->assertIsInt($values);
    }
}
