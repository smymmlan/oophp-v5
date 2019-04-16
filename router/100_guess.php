<?php
/**
 * Create routes using $app programming style.
 */
//var_dump(array_keys(get_defined_vars()));

/**
 * Init the game and redirect to play the game.
 */
$app->router->get("guess/init", function () use ($app) {
    // init the session for the game start";
            $Guess = new Tuss\Guess\Guess();
            (int)$_SESSION["secretNo"] = $Guess->getSecretNo();
            (int)$_SESSION["try"] = $Guess->getTry();
            $_SESSION["guessedNo"] = null;
            $_SESSION["str"] = null;


    $data = [
        // "secretNo" => $secretNo ?? null,
        "guessedNo" => $guessedNo ?? null
    ];

    return $app->response->redirect("guess/play", $data);
});



/**
 * play the game- show game status.
 */
$app->router->get("guess/play", function () use ($app) {
    $title = "Spela spelet";

    //deal with incoming
    $_SESSION["str"] = $_SESSION["str"] ?? null;
    $_SESSION["secretNo"] = $_SESSION["secretNo"] ?? null;
    $_SESSION["guessedNo"] = $_SESSION["guessedNo"] ?? null;
    $try = $_SESSION["try"];
    $secretNo = $_SESSION["secretNo"];
    $startOverBtn = $startOverBtn ?? null;

    if ($startOverBtn === null || $guessedNo === null) {
        $Guess = new Tuss\Guess\Guess($secretNo, $try);
        $secretNo = $Guess->getSecretNo();
        (int)$_SESSION["try"] = $Guess->getTry();
        (int)$_SESSION["secretNo"] = $Guess->getSecretNo();
    }

    $data = [
        "secretNo" => $secretNo ?? null,
        "guessedNo" => $guessedNo ?? null
        //skicka in allt som behövs i vyn
    ];

    $app->page->add("guess/play", $data);
    // $app->page->add("guess/debug");

    return $app->page->render([
        "title" => $title,
    ]);
});

/**
 * play the game -make a guess.
 */
$app->router->post("guess/play", function () use ($app) {
    $title = "Spela spelet";

    //deal with incoming
    $secretNo = $_POST["secretNo"] ?? null;
    $guessedNo = $_POST["guessedNo"] ?? null;
    $_SESSION["try"] = $_SESSION["try"] ?? null;
    $guessBtn = $_POST["guessBtn"] ?? null;
    $startOverBtn = $_POST["startOverBtn"] ?? null;
    $cheatBtn = $_POST["cheatBtn"] ?? null;

    if (isset($guessBtn)) {
        // do a guess
        try {
            $Guess = new Tuss\Guess\Guess((int)$secretNo, (int)$_SESSION["try"]);
            $_SESSION["guessedNo"] = $guessedNo;
            $_SESSION["str"] = $Guess->makeGuess((int)$guessedNo);
            (int)$_SESSION["try"] = $Guess->getTry();
        } catch (Tuss\Guess\GuessException $e) {
            $errorMsg = $e->getMessage();
            $_SESSION["str"] = "<b>{$errorMsg}</b>";
        }
    } elseif (isset($cheatBtn)) {
        $str = "Det hemliga numret är " . $_SESSION["secretNo"];
        $_SESSION["str"] = $str;
    } elseif (isset($startOverBtn)) {
        return $app->response->redirect("guess/init");
    }
    return $app->response->redirect("guess/play");
});
