<?php

namespace Tuss\Dice100;

use PHPUnit\Framework\TestCase;

/**
 * Example test class.
 */
class DiceTurnTest extends TestCase
{
    /**
     * creating object
     */
    public function testCreateObjectDiceTurn()
    {
        $diceTurn = new DiceTurn();
        $this->assertInstanceOf("\Tuss\Dice100\DiceTurn", $diceTurn);
    }

    /**
     * test if points is set to zero
     */
    public function testIfPointsIsSetToZero()
    {
        $diceTurn = new DiceTurn();
        $this->assertInstanceOf("\Tuss\Dice100\DiceTurn", $diceTurn);

        $res = $diceTurn->getPoints();
        $exp = 0;

        $this->assertEquals($exp, $res);
    }

    /**
     * test If points is reset
     */
    public function testIfPointsIsReset()
    {
        $diceTurn = new DiceTurn();
        $this->assertInstanceOf("\Tuss\Dice100\DiceTurn", $diceTurn);

        $res = $diceTurn->resetPoints();
        $exp = 0;

        $this->assertEquals($exp, $res);
    }
}
