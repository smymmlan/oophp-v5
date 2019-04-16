<?php

namespace Anax\View;

/**
 * Render content within an article.
 */

// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());

?>
<h2>Gissa det hemliga nummret</h2>
<p>Gissa på ett nummer mellan 1 och 100. Du har <?= $_SESSION["try"] ?> gånger kvar. </p>
<form method="post">
    <br/>
    <fieldset>
        <legend>Gissa numret:</legend>
            <input type = "text" name = "guessedNo" value="<?= $guessedNo ?>"></input><br/><br/>
            <p><?= $_SESSION["str"] ?></p>
            <input type="hidden" name="secretNo" value="<?= $_SESSION["secretNo"] ?>"></input>
            <input type="hidden" name="try" value="<?= $_SESSION["try"] ?>"></input>
        <?php if ($_SESSION["try"] === 0 || $_SESSION["guessedNo"] == $_SESSION["secretNo"]) { ?>
                <?php echo '<input type = "button" disabled="true" name = "guessBtn" value="Gissa" ></input><br/><br/>'; ?>
                <?php echo '<input type = "submit" name = "startOverBtn" value="Börja om" ></input><br/><br/>'; ?>
                <?php echo '<input type = "button" disabled="true" name = "cheatBtn" value="Fuska!"></input><br/><br/>'; ?>
        <?php } else { ?>
            <?php echo '<input type = "submit" name = "guessBtn" value="Gissa" ></input><br/><br/>'; ?>
            <?php echo '<input type = "submit" name = "startOverBtn" value="Börja om" ></input><br/><br/>'; ?>
            <?php echo '<input type = "submit" name = "cheatBtn" value="Fuska!"></input><br/><br/>'; ?>
        <?php } ?>
    </fieldset>
</form>
