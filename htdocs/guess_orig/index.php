<?php
/**
 * Guess My Number
 */

include(__DIR__ . "/config.php");
include(__DIR__ . "/autoload.php");
include(__DIR__ . "/src/functions.php");

// take care of incoming variables

$secretNo = $_POST["secretNo"] ?? null;
$guess = $_POST["guess"] ?? null;
$_SESSION["try"] = $_SESSION["try"] ?? null;
$guessBtn = $_POST["guessBtn"] ?? null;
$startOverBtn = $_POST["startOverBtn"] ?? null;
$cheatBtn = $_POST["cheatBtn"] ?? null;

$str = "";

if ((int)$_SESSION["try"] === 1) {
    $Guess = new Guess();
    $secretNo = $Guess->getSecretNo();
    (int)$_SESSION["try"] = $Guess->getTry();
    $str = "Nytt Spel! Gissa på det nya numret.";
} elseif (isset($guessBtn)) {
    $Guess = new Guess($secretNo, (int)$_SESSION["try"]);
    $str = $Guess->makeGuess((int)$guess);
    (int)$_SESSION["try"] = $Guess->getTry();
} elseif (isset($cheatBtn)) {
    $str = "Det hemliga nummret är " . $secretNo;
} elseif (isset($startOverBtn)) {
    $Guess = new Guess();
    (int)$_SESSION["try"] = $Guess->getTry();
    $secretNo = $Guess->getSecretNo();
    $str = "Spelet är omstartat";
} elseif ($startOverBtn === null || $guess === null) {
    $Guess = new Guess();
    $secretNo = $Guess->getSecretNo();
    (int)$_SESSION["try"] = $Guess->getTry();
    $str = "Gissa på ett nummer";
}

require(__DIR__ . "/view/guess_form.php");
