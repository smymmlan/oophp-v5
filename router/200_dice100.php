<?php
/**
 * Create routes using $app programming style.
 */
//var_dump(array_keys(get_defined_vars()));

/**
 * Init the game and redirect to play the game.
 */
$app->router->post("dice100/init", function () use ($app) {
    //session_destroy();
    $quantity = $_POST["quantity"] ?? null;

    if (empty($quantity)) {
        $quantity = 3;
    }

    $_SESSION["game"] = new Tuss\Dice100\Dice100($quantity);

    return $app->response->redirect("dice100/nextturn", $data);
});


/**
 * route to handle events when it is a new turn. Change player and
 * redirect accoringly.
 */
$app->router->get("dice100/nextturn", function () use ($app) {
    $title = "Tärningsspelet";
    $stringi="";

    $_SESSION["game"]->changePlayer();
    $_SESSION["game"]->newTurn();
    $currentPlayer = $_SESSION["game"]->currentlyPlaying();

    if ($currentPlayer === 0) {
        return $app->response->redirect("dice100/playerturn");
    } elseif ($currentPlayer === 1) {
        return $app->response->redirect("dice100/computerturn");
    }
});

/**
 *  route to handle events when player plays. Controll if a one is thrown
 * and redirect accordingly.
 *
 */
$app->router->get("dice100/playerturn", function () use ($app) {
    $title = "Tärningsspelet";
    $checkIfOneIsRolled = $_SESSION['game']->playerPlays();
    $data = $_SESSION["game"]->getGameStatistics();

    if ($checkIfOneIsRolled === true) {
        $app->page->add("dice100/result", $data);
    } else {
        $app->page->add("dice100/play", $data);
    }

    // $app->page->add("dice100/debug", $data);

    return $app->page->render([
        "title" => $title,
    ]);
});

/**
 * route to handle events when computer plays
 * Control player score and redirect to finish the game if score is 100 or more.
 */
$app->router->get("dice100/computerturn", function () use ($app) {
    $title = "Tärningsspelet";
    $graphic = $_SESSION["game"]->computerPlays();
    $data = $_SESSION["game"]->getGameStatistics();

    if ($_SESSION["game"]->returnComputerPoints() >= 100) {
        return $app->response->redirect("dice100/winner");
    } else {
        $app->page->add("dice100/result", $data);
        // $app->page->add("dice100/debug", $data);

        return $app->page->render([
            "title" => $title,
        ]);
    }
});

/**
 * route when rollbutton is press. redirects to players-turn route
 */
$app->router->post("dice100/roll", function () use ($app) {
    $title = "Tärningsspelet";

    return $app->response->redirect("dice100/playerturn");
});


/**
 * route to handle events when player wants to save and end turn.
 * Control player score and redirect to finish the game if score is 100 or more.
 */
$app->router->post("dice100/save", function () use ($app) {
    $title = "Tärningsspelet";
    $_SESSION["game"]->savePlayerScore();

    if ($_SESSION["game"]->returnPlayerPoints() >= 100) {
        return $app->response->redirect("dice100/winner");
    } else {
        return $app->response->redirect("dice100/nextturn");
    }
});

/**
 * route for when computer or player wins. Shows last throw and score
 */
$app->router->get("dice100/winner", function () use ($app) {
    $title = "Tärningsspelet";
    $data = $_SESSION["game"]->getGameStatistics();

    $app->page->add("dice100/winner", $data);
    // $app->page->add("dice100/debug", $data);

    return $app->page->render([
        "title" => $title,
    ]);
});
