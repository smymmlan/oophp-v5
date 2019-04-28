<?php

namespace Anax\View;

/**
 * Render content within an article.
 */

// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());

?><!doctype html>
<meta charset="utf-8">
<h2>Spela tärningspelet -först till 100 vinner </h2>

<form method="post" class="diceGameForm">
    <br/>
    <p class="pNoMrg">  <?= $_SESSION["message"] ?></p>
    <fieldset><br/>
        <div class="diceBox">
        <div class="playerDice">
        <input type = "submit" name = "roll" value="Kasta tärningarna" ></input><br/>
        <p> <?= $playerDicePics ?>
        </p>
        <br />
        <input type = "submit" name = "save" value="Spara poängen" ></input><br/>
        <input type = "submit" name = "startOver" value="Starta om"></input><br/>
    </div>
        <div class="computerDice">
            <p class="pDice">Datorns tärningar:</p>
            <p> <?= $computerDicePics ?> </p>
    </div>
    <div class="score">
        <p>Datorns poäng: <?= $computerPoints ?></p>
        <p>Dina poäng: <?= $playerPoints ?></p>
    </div>
</div>

    </fieldset>
</form>
