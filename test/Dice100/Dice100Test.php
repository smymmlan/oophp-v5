<?php

namespace Tuss\Dice100;

use PHPUnit\Framework\TestCase;

/**
 * Example test class.
 */
class Dice100Test extends TestCase
{
    /**
     * Just assert something is true.
     */
    public function testCreateObjectDice100NoArgReturnPlayerPoints()
    {
        $game = new Dice100();
        $this->assertInstanceOf("\Tuss\Dice100\Dice100", $game);

        $res = $game->returnPlayerPoints();
        $exp = 0;
        $this->assertEquals($exp, $res);
    }

    /**
     * Test create object and check if computer points returns 0
     */
    public function testCreateObjectDice100NoArgReturnComputerPoints()
    {
        $game = new Dice100();
        $this->assertInstanceOf("\Tuss\Dice100\Dice100", $game);

        $res = $game->returnComputerPoints();
        $exp = 0;
        $this->assertEquals($exp, $res);
    }

    /**
     * control the current player randomization -is 0 or 1
     */
    public function testCurrentPlayerValue()
    {
        $game = new Dice100();
        $this->assertInstanceOf("\Tuss\Dice100\Dice100", $game);

        $res = $game->currentlyPlaying();
        $exp = [0,1];
        $this->assertContains($res, $exp);
    }

    /**
     * control the changingPLayer method. Control if it changes value
     */
    public function testChangingPlayerMethod()
    {
        $game = new Dice100();
        $this->assertInstanceOf("\Tuss\Dice100\Dice100", $game);

        $oldPlayer = $game->currentlyPlaying();
        $game->changePlayer();
        $newPlayer = $game->currentlyPlaying();
        $this->assertNotEquals($oldPlayer, $newPlayer);
        $newPlayer = $game->currentlyPlaying();
        $game->changePlayer();
        $oldPlayer = $game->currentlyPlaying();
        $this->assertNotEquals($oldPlayer, $newPlayer);
    }

    /**
     * control that the playername changes depending on whos turn it is,
     * -who is current player
     */
    public function testPlayerNameMethod()
    {
        $game = new Dice100();
        $this->assertInstanceOf("\Tuss\Dice100\Dice100", $game);

        $oldPlayerName = $game->playerName();
        $game->changePlayer();
        $newPlayerName = $game->playerName();
        $this->assertNotEquals($oldPlayerName, $newPlayerName);
    }

    /**
     * test if the return value is of type string
     *
     */
    public function testPlayerNameMethodReturnsString()
    {
        $game = new Dice100();
        $this->assertInstanceOf("\Tuss\Dice100\Dice100", $game);

        $str = $game->playerName();
        $this->assertIsString($str);
    }

    /**
     * test if the return value is of type string
     *
     */
    public function testNewTurnWhenComputerPlays()
    {
        $game = new Dice100();
        $this->assertInstanceOf("\Tuss\Dice100\Dice100", $game);

        $game->newTurn();
        $graph = $game->computerPLays();
        $graph = $graph[0][0];
        $this->assertIsString($graph);
    }

    /**
     * test if the return value is of type int
     *
     */
    public function testComputerPlaysIfItIsInt()
    {
        $game = new Dice100();
        $this->assertInstanceOf("\Tuss\Dice100\Dice100", $game);

        $game->newTurn();
        $game->computerPLays();
        $points = $game->returnComputerPoints();
        $this->assertIsInt($points);
    }

    /**
     * test if the return value is of type boolean
     *
     */
    public function testIfReturnsBooleanWhenPlayerPlays()
    {
        $game = new Dice100();
        $this->assertInstanceOf("\Tuss\Dice100\Dice100", $game);

        $game->newTurn();
        $bol = $game->playerPLays();
        $this->assertIsBool($bol);
    }

    /**
     * test if the return value is of type string
     *
     */
    public function testIfGraphicStringReturnsWhenPlayerPlays()
    {
        $game = new Dice100();
        $this->assertInstanceOf("\Tuss\Dice100\Dice100", $game);

        $game->newTurn();
        $game->playerPLays();
        $str = $game->returnPlayerGraphic();
        $this->assertIsString($str[0]);
    }

    /**
     * test if the return value is of type string and contains "dice-"
     *
     */
    public function testIfGraphicStringContainKeyWord()
    {
        $game = new Dice100();
        $this->assertInstanceOf("\Tuss\Dice100\Dice100", $game);

        $game->newTurn();
        $game->playerPLays();
        $str = $game->returnPlayerGraphic();
        $this->assertRegexp('/dice-/', $str[0]);
    }

    /**
     * test if the return value is of type string
     *
     */
    public function testIfCreateHistogramReturnString()
    {
        $game = new Dice100();
        $this->assertInstanceOf("\Tuss\Dice100\Dice100", $game);

        $game->newTurn();
        $game->playerPLays();
        $game->createHistogram();
        $data = $game->getGameStatistics();

        //Set the internal pointer to the end.
        end($data);

        //Retrieve the key of the current element.
        $key = key($data);

        $this->assertIsString($key);
    }

    /**
     * test that computer rolls three times when player is more than 10 points
     * ahead. Also makesure that player has more points than computer after
     * 50 rolls. Computer rolls once.
     */
    public function testComputerPlaysUsingLoop()
    {
        $game = new Dice100();
        $this->assertInstanceOf("\Tuss\Dice100\Dice100", $game);

        $game->newTurn();
        for ($i=0; $i<50; $i++) {
            $game->playerPlays();
            $game->savePlayerScore();
        }
        $game->computerPlays();
        $pp = $game->returnPlayerPoints();
        $cp = $game->returnComputerPoints();

        $this->assertGreaterThan($cp, $pp);
    }
}
