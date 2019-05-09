<?php

namespace Tuss\Dice100;

use Anax\Commons\AppInjectableInterface;
use Anax\Commons\AppInjectableTrait;

// use Anax\Route\Exception\ForbiddenException;
// use Anax\Route\Exception\NotFoundException;
// use Anax\Route\Exception\InternalErrorException;

/**
 * A sample controller to show how a controller class can be implemented.
 * The controller will be injected with $app if implementing the interface
 * AppInjectableInterface, like this sample class does.
 * The controller is mounted on a particular route and can then handle all
 * requests for that mount point.
 *
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class Dice100Controller implements AppInjectableInterface
{
    use AppInjectableTrait;



    /**
     * @var string $db a sample member variable that gets initialised
     */
    // private $db = "not active";



    /**
     * The initialize method is optional and will always be called before the
     * target method/action. This is a convienient method where you could
     * setup internal properties that are commonly used by several methods.
     *
     * @return void
     */
    // public function initialize() : void
    // {
    //     // Use to initialise member variables.
    //     $this->db = "active";
    //
    //     // Use $this->app to access the framework services.
    // }



    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return string
     */
    public function indexAction() : string
    {
        // Deal with the action and return a response.
        return "Hej hej!";
    }

    /**
     *
     * @return object
     */
    public function initActionPost() : object
    {
        $session = $this->app->session;
        $response = $this->app->response;
        $request = $this->app->request;

        $quantity = $request->getPost("quantity");

        if (empty($quantity)) {
            $quantity = 3;
        }

        $game = new Dice100($quantity);
        $session->set("game", $game);

        return $response->redirect("dice100game/nextturn");
    }

    /**
     *
     * @return object
     */
    public function nextturnAction() : object
    {
        $session = $this->app->session;
        $response = $this->app->response;

        $session->get("game")->changePlayer();
        $session->get("game")->newTurn();
        $currentPlayer = $session->get("game")->currentlyPlaying();

        if ($currentPlayer === 0) {
            return $response->redirect("dice100game/playerturn");
        } elseif ($currentPlayer === 1) {
            return $response->redirect("dice100game/computerturn");
        }
    }

    /**
     *
     * @return object
     */
    public function playerturnAction() : object
    {
        $session = $this->app->session;
        $page = $this->app->page;

        $title = "Tärningsspelet";
        $checkIfOneIsRolled = $session->get("game")->playerPlays();
        $session->get("game")->createHistogram();
        $data  = $session->get("game")->getGameStatistics();

        if ($checkIfOneIsRolled === true) {
            $page->add("dice100game/result", $data);
        } else {
            $page->add("dice100game/play", $data);
        }

        // $app->page->add("dice100/debug", $data);
        return $page->render([
            "title" => $title,
        ]);
    }

    /**
     *
     * @return object
     */
    public function computerturnAction() : object
    {
        $session = $this->app->session;
        $response = $this->app->response;
        $page = $this->app->page;

        $title = "Tärningsspelet";

        $session->get("game")->computerPlays();
        $session->get("game")->createHistogram();
        if ($session->get("game")->returnComputerPoints() >= 100) {
            return $response->redirect("dice100game/winner");
        }
        $data  = $session->get("game")->getGameStatistics();
        $page->add("dice100game/result", $data);
            // $app->page->add("dice100/debug", $data);

        return $page->render([
            "title" => $title,
        ]);
    }

    /**
     *
     * @return object
     */
    public function rollActionPost() : object
    {
        $response = $this->app->response;

        return $response->redirect("dice100game/playerturn");
    }

    /**
     *
     * @return object
     */
    public function saveActionPost() : object
    {
        $session = $this->app->session;
        $response = $this->app->response;

        $session->get("game")->savePlayerScore();

        if ($session->get("game")->returnPlayerPoints() >= 100) {
            return $response->redirect("dice100game/winner");
        } else {
            return $response->redirect("dice100game/nextturn");
        }
    }

    /**
     *
     * @return object
     */
    public function winnerAction() : object
    {
        $session = $this->app->session;
        $page = $this->app->page;

        $title = "Tärningsspelet";
        $data = $session->get("game")->getGameStatistics();

        $page->add("dice100game/winner", $data);
        // $app->page->add("dice100/debug", $data);

        return $page->render([
            "title" => $title,
        ]);
    }
}
