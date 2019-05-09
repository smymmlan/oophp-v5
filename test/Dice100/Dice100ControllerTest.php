<?php

namespace Tuss\Dice100;

use Anax\Controller\SampleAppController;
use Anax\Response\ResponseUtility;
use Anax\DI\DIMagic;
use PHPUnit\Framework\TestCase;

/**
 * Test the controller like it would be used from the router,
 * simulating the actual router paths and calling it directly.
 */
class Dice100ControllerTest extends TestCase
{
    private $controller;
    private $app;


    /**
     * Setup the controller, before each testcase, just like the router
     * would set it up.
     */
    protected function setUp(): void
    {
        global $di;
        // Init service container $di to contain $app as a service
        $di = new DIMagic();
        $di->loadServices(ANAX_INSTALL_PATH . "/config/di");
        $app = $di;
        $this->app = $app;
        $di->set("app", $app);

        // Create and initiate the controller
        $this->controller = new Dice100Controller();
        $this->controller->setApp($app);
        // $this->controller->initialize();
    }

    /**
     * Call the controller index action.
     */
    public function testIndexAction()
    {
        $res = $this->controller->indexAction();
        $this->assertIsString($res);
        $this->assertStringContainsString("hej!", $res);
    }

    /**
     * Call the controller init action.
     */
    public function testInitAction()
    {
        $res = $this->controller->initActionPost();
        $this->assertInstanceOf(ResponseUtility::class, $res);
    }

    /**
     * Call the controller nextTurn action.
     */
    public function testNextTurnAction()
    {
        for ($i=0; $i<10; $i++) {
            $res = $this->controller->nextTurnAction();
            $this->assertInstanceOf(ResponseUtility::class, $res);
        }
    }

    /**
     * Call the controller playerTurn action.
     */
    public function testPlayerTurnAction()
    {
        for ($i=0; $i<10; $i++) {
            $res = $this->controller->playerTurnAction();
            $this->assertInstanceOf(ResponseUtility::class, $res);
        }
    }

    /**
     * Call the controller computerTurn action.
     */
    public function testComputerTurnAction()
    {
        for ($i=0; $i<10; $i++) {
            $res = $this->controller->computerTurnAction();
            $this->assertInstanceOf(ResponseUtility::class, $res);
        }
    }

    /**
     * Call the controller roll-action-post.
     */
    public function testRollActionPost()
    {
        $res = $this->controller->rollActionPost();
        $this->assertInstanceOf(ResponseUtility::class, $res);
    }

    /**
     * Call the controller save-action-post.
     */
    public function testSaveActionPost()
    {
        for ($i=0; $i<10; $i++) {
            $res = $this->controller->saveActionPost();
            $this->assertInstanceOf(ResponseUtility::class, $res);
        }
    }

    /**
     * Call the controller winner action.
     */
    public function testWinnerAction()
    {
        $res = $this->controller->winnerAction();
        $this->assertInstanceOf(ResponseUtility::class, $res);
    }
}
