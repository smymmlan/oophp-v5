<?php

namespace Anax\View;

/**
 * Render content within an article.
 */

// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());

?><!doctype html>
<meta charset="utf-8">
<h2>Spela tärningspelet -först till 100 vinner.</h2>

<form method="post" class="diceGameForm">
    <fieldset><br/>
        <div class="diceBox">
        <div class="playerDice">
        <input type = "submit" name = "roll" value="Kasta tärningarna" formaction="roll"></input><br/>
        <input type = "submit" name = "save" value="Spara poängen" formaction="save"></input><br/>
    </div>
        <div class="computerDice">
                <?php if (isset($dicePics)) { ?>
                    <p>
                        <?= $currentPlayer ?> slog:
                    </p>
                    <?php $j = count($dicePics);?>

                    <?php for ($i=0; $i<$j; $i++) { ?>
                        <?= "<p></p>" ?>
                            <?php foreach ($dicePics[$i] as $key => $value) {?>
                                    <i class="dice-sprite ' . <?= $value ?> . '"></i>
                            <?php } ?>
                    <?php } ?>
                <?php } ?>

                  <p>
                        <?= $currentPlayer ?> fick <?= $turnPoints ?> poäng.
                  </p>
    </div>
    <div class="score">
        <p>Datorns poäng: <?= $computerPoints ?></p>
        <p>Dina poäng: <?= $playerPoints ?></p>
    </div>
</div>

    </fieldset>
</form>
