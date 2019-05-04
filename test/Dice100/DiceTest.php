<?php

namespace Tuss\Dice100;

use PHPUnit\Framework\TestCase;

/**
 * Example test class.
 */
class DiceTest extends TestCase
{
    /**
     * checking if the return values match the values
     */
    public function testCreateObjectDiceNoArgReturnPlayerPoints()
    {
        $dice = new Dice();
        $this->assertInstanceOf("\Tuss\Dice100\Dice", $dice);

        $rolledDice = $dice->rollDice();
        $lastRolledDice = $dice->getLastRoll();

        $this->assertSame($rolledDice, end($lastRolledDice));
    }

    /**
     * test that number of dice-roll is between 0 and sides
     */
    public function testValueOfDiceRollIsBetweenNrOfSidesOnDice()
    {
        $dice = new Dice(8);
        $this->assertInstanceOf("\Tuss\Dice100\Dice", $dice);

        for ($i=0; $i<20; $i++) {
            $dice->rollDice();
            $value = $dice->getLastRoll();

            $this->assertThat(
                $value[0],
                $this->logicalAnd(
                    $this->greaterThan(0),
                    $this->lessThan(9)
                )
            );
        }
    }

    /**
     * test that number of sides on dice
     */
    public function testNoOffSIdesOnDice()
    {
        $dice = new Dice(8);

        $res = $dice->getSides();
        $exp = 8;

        $this->assertEquals($exp, $res);
    }

    /**
     * test that number of sides is 6 as default
     */
    public function testNoOffSIdesOnDiceDefaultsTo6()
    {
        $dice = new Dice();

        $res = $dice->getSides();
        $exp = 6;

        $this->assertEquals($exp, $res);
    }
}
