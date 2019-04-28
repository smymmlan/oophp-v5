<?php
/**
 * Create routes using $app programming style.
 */
//var_dump(array_keys(get_defined_vars()));

/**
 * Init the game and redirect to play the game.
 */
$app->router->post("dice100/init", function () use ($app) {
    // init the session for the game start";
    // session_destroy();
    if (isset($_SESSION["turn"]) || (isset($_SESSION["game"]))) {
        unset($_SESSION["turn"]);
        unset($_SESSION["game"]);
    }

    if (isset($_SESSION["quantity"]) || (isset($_SESSION["graphic"]))) {
        $_SESSION["quantity"] = null;
        $_SESSION["graphic"] = null;
        $_SESSION["computerGraphic"] = null;
        $_SESSION["status"] = $_SESSION["message"] = "";
    }
    $_SESSION["computerPoints"] = 0;
    $_SESSION["playerPoints"] = 0;
    $_SESSION["quantity"] = $_POST["quantity"] ?? null;
    $quantity = $_SESSION["quantity"];

    // new game object -insert nr of dice to play with
    $_SESSION["game"] = new Tuss\Dice100\Dice100($quantity);
    $_SESSION["computerGraphic"] = $_SESSION["game"]->returnGetAllGraph();
    $_SESSION["message"] = $_SESSION["game"]->returnStr();

    $_SESSION["graphic"] = $_SESSION["game"]->returnCompGraph();
    $_SESSION["computerPoints"] = $_SESSION["game"]->returnComputerPoints();

    return $app->response->redirect("dice100/play", $data);
});

/**
 * Init the game and redirect to play the game.
 * Use get when player RESTARTS the game. Keep the same amount of dice
  * REEEESARRRRTTTTTTTTTTTTTTTTTTT RESTART RESTARTS REEEESTAAAAAAAAARt
 */
$app->router->get("dice100/init", function () use ($app) {
    // init the session for the game start";
    if (isset($_SESSION["graphic"]) || isset($_SESSION["save"])) {
        $_SESSION["graphic"] = null;
        $_SESSION["computerGraphic"] = "";
    }
    // take away object for turn
    unset($_SESSION["game"]);
    unset($_SESSION["turn"]);

    // create new game-object -reuse same amount dice
    //save new values in session

    $quantity = (int)$_SESSION["quantity"];

    $_SESSION["game"] = new Tuss\Dice100\Dice100($quantity);
    $_SESSION["turn"] = new Tuss\Dice100\DiceTurn($quantity);
    $str = $_SESSION["game"]->returnStr();
    $_SESSION["message"] = $str;
    $compGraph = $_SESSION["game"]->returnCompGraph();
    $_SESSION["computerGraphic"] = $_SESSION["game"]->returnGetAllGraph();
    $_SESSION["graphic"] = $compGraph;
    $_SESSION["computerPoints"] = 0;
    $_SESSION["playerPoints"] = 0;
    $_SESSION["computerPoints"] = $_SESSION["game"]->returnComputerPoints();
    $_SESSION["playerPoints"] = $_SESSION["game"]->returnPlayerPoints();


    return $app->response->redirect("dice100/play", $data);
});

/**
 * play the game- show game status.
 */
$app->router->get("dice100/play", function () use ($app) {
    $title = "Tärningsspelet";
    $playerStringi = $stringi = "";

    $_SESSION["game"] ->controlComputerStatus();
    $checkIfGameIsOver = $_SESSION["game"]->returnStr();
    if ($checkIfGameIsOver === "Game Over! Datorn vann.") {
        $_SESSION["message"] = $checkIfGameIsOver;
        return $app->response->redirect("dice100/gameover");
    }

    if (isset($_SESSION["computerGraphic"])) {
            $j = count(($_SESSION["computerGraphic"]));
             for ($i=0; $i<$j; $i++) {
                $stringi .=  '<p> </p>';
                 foreach ($_SESSION["computerGraphic"][$i] as $key => $value) {
                    $stringi .= '<i class="dice-sprite ' . $value . '"></i>';
                 }
             }
         }

         if (isset($_SESSION["graphic"])) {
                 foreach ($_SESSION["graphic"] as $key => $value) {
                     $playerStringi .=  '<i class="dice-sprite ' . $value . '"></i>';
                  }
         }

    $data = [
        "computerDicePics" => $stringi,
        "playerDicePics" => $playerStringi,
        "computerPoints" => $_SESSION["game"]->returnComputerPoints(),
        "playerPoints" => $_SESSION["game"]->returnPlayerPoints()
    ];

    $app->page->add("dice100/play", $data);
    $app->page->add("dice100/debug", $data);

    return $app->page->render([
        "title" => $title,
    ]);
});

/**
 * Check witch buttons were pressed and redirect accordingly
 */
$app->router->post("dice100/play", function () use ($app) {
    $title = "Tärningsspelet";

    // check witch buttons were pressed
    $roll = $_POST["roll"] ?? null;
    $startOver = $_POST["startOver"] ?? null;
    $save = $_POST["save"] ?? null;

    // a roll is made
    if (isset($roll)) {
        $_SESSION["roll"] = $roll;
        return $app->response->redirect("dice100/roll", $data);
    }
    // restart with the same nr of dice
    if (isset($startOver)) {
        return $app->response->redirect("dice100/init");
    }
    //player wants to save and end turn
    if (isset($save)) {
        return $app->response->redirect("dice100/save");
    }

    return $app->response->redirect("dice100/play");
});

/**
 * route to handle events when dices are thrown.
 */
$app->router->get("dice100/roll", function () use ($app) {
    $title = "Tärningsspelet";
    $quantity = $_SESSION["quantity"];

    if(!isset($_SESSION["turn"])) {
        $_SESSION["turn"] = new Tuss\Dice100\DiceTurn($quantity);
    }

    $_SESSION["status"] = "";
    $_SESSION["message"] = "Kasta igen eller spara dina poäng";
    $_SESSION["turn"]->throw();
    $_SESSION["turn"]->setStatus();
    // $_SESSION["computerGraphic"] = null;
    $_SESSION["graphic"] = $_SESSION["turn"]->getGraphic();
    // $_SESSION["playerPoints"] = $_SESSION["turn"]->getPoints();
    $_SESSION["status"] = $_SESSION["turn"]->returnStatus();
    $_SESSION["graphic"] = $_SESSION["turn"]->getGraphic();

    if ($_SESSION["status"] === "red") {
        $_SESSION["graphic"] = $_SESSION["game"]->getGraphic();
        $_SESSION["graphic"] = $_SESSION["turn"]->getGraphic();
        $_SESSION["playerPoints"] = $_SESSION["game"]->returnPlayerPoints();
        return $app->response->redirect("dice100/computerplay");
    }

    return $app->response->redirect("dice100/play");
});

/**
 * route to handle events when player wants to save and end turn.
 */
$app->router->get("dice100/save", function () use ($app) {
    $title = "Tärningsspelet";

    if ($_SESSION["status"] == "green") {
        $_SESSION["game"]->savePlayerPoints($_SESSION["turn"]->getPoints());
        $_SESSION["game"]->destroy();
        unset($_SESSION["turn"]);
        $_SESSION["playerPoints"] = $_SESSION["game"]->returnPlayerPoints();
        $_SESSION["computerGraphic"] = $_SESSION["game"]->returnGetAllGraph();
        return $app->response->redirect("dice100/computerplay");
    }

    return $app->response->redirect("dice100/play");
});

/**
 * route to handle events when computer plays
 */
$app->router->get("dice100/computerplay", function () use ($app) {

    $_SESSION["computerGraphic"] = $_SESSION["game"]->returnGetAllGraph();
    $_SESSION["computerPoints"] = $_SESSION["game"]->returnComputerPoints();
    $_SESSION["message"] = "Datorn spelade och nu är det din tur igen";
    $_SESSION["game"]->computerPlays();
    $_SESSION["computerGraphic"] = $_SESSION["game"]->returnGetAllGraph();
    $_SESSION["graphic"] = null;
    $_SESSION["computerPoints"] = $_SESSION["game"]->returnComputerPoints();
    $_SESSION["game"]->destroy();

    return $app->response->redirect("dice100/play");
});

/**
 * play the game- show game status.
 */
$app->router->get("dice100/gameover", function () use ($app) {
    $title = "Tärningsspelet";
    $playerStringi = $stringi = "";

    if (isset($_SESSION["computerGraphic"])) {
            $j = count(($_SESSION["computerGraphic"]));
             for ($i=0; $i<$j; $i++) {
                $stringi .=  '<p> </p>';
                 foreach ($_SESSION["computerGraphic"][$i] as $key => $value) {
                    $stringi .= '<i class="dice-sprite ' . $value . '"></i>';
                 }
             }
         }

         if (isset($_SESSION["graphic"])) {
                 foreach ($_SESSION["graphic"] as $key => $value) {
                     $playerStringi .=  '<i class="dice-sprite ' . $value . '"></i>';
                  }
         }

    $data = [
        "computerDicePics" => $stringi,
        "playerDicePics" => $playerStringi,
        "computerPoints" => $_SESSION["game"]->returnComputerPoints(),
        "playerPoints" => $_SESSION["game"]->returnPlayerPoints()
    ];

    $app->page->add("dice100/gameover", $data);
    $app->page->add("dice100/debug", $data);

    return $app->page->render([
        "title" => $title,
    ]);
});

/**
 * Check witch buttons were pressed and redirect accordingly
 */
$app->router->post("dice100/gameover", function () use ($app) {
    $title = "Tärningsspelet";

    // check witch buttons were pressed
    $startOver = $_POST["startOver"] ?? null;

    // restart with the same nr of dice
    if (isset($startOver)) {
        return $app->response->redirect("dice100/init");
    }

    return $app->response->redirect("dice100/play");
});



//
