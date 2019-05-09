<?php

namespace Tuss\Dice100;

use PHPUnit\Framework\TestCase;

/**
 * Example test class.
 */
class Dice100Test extends TestCase
{
    /**
     * Test the return value of comp-points and player-points
     */
    public function testCreateObjectDice100NoArgReturnPlayerPoints()
    {
        $game = new Dice100();
        $this->assertInstanceOf("\Tuss\Dice100\Dice100", $game);

        $res = $game->returnPlayerPoints();
        $exp = 0;
        $this->assertEquals($exp, $res);
        $res = $game->returnComputerPoints();
        $exp = 0;
        $this->assertEquals($exp, $res);
    }

    /**
     * control the changingPLayer method. Control if it changes value
     * control the current player randomization -is 0 or 1
     */
    public function testChangingPlayerMethod()
    {
        $game = new Dice100();
        $this->assertInstanceOf("\Tuss\Dice100\Dice100", $game);

        $res = $game->currentlyPlaying();
        $exp = [0,1];
        $this->assertContains($res, $exp);

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
     * -who is current player and is the return value type string
     */
    public function testPlayerNameMethod()
    {
        $game = new Dice100();
        $this->assertInstanceOf("\Tuss\Dice100\Dice100", $game);

        $oldPlayerName = $game->playerName();
        $game->changePlayer();
        $newPlayerName = $game->playerName();
        $this->assertNotEquals($oldPlayerName, $newPlayerName);
        $this->assertIsString($newPlayerName);
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
        $pPoints = $game->returnPlayerPoints();
        $cPoints = $game->returnComputerPoints();

        $this->assertGreaterThan($cPoints, $pPoints);
    }
}
