
<h2>Gissa det hemliga nummret</h2>
<p>Gissa på ett nummer mellan 1 och 100. Du har <?= $_SESSION["try"] ?> gånger kvar. </p>
<form method="post" action="index.php">
    <br/>
    <fieldset>
        <legend>Gissa numret:</legend>
            <input type = "text" name = "guess" value="<?= $guess ?>"></input><br/><br/>
            <p><?= $str ?></p>
            <input type="hidden" name="secretNo" value="<?= $secretNo ?>"></input>
            <input type="hidden" name="try" value="<?= $_SESSION["try"] ?>"></input>
            <input type = "submit" name = "guessBtn" value="Gissa" ></input><br/><br/>
            <input type = "submit" name = "startOverBtn" value="Börja om" ></input><br/><br/>
            <input type = "submit" name = "cheatBtn" value="Fuska!"></input><br/><br/>
    </fieldset>
</form>
