<?php

namespace Anax\View;

if (!$res) {
    return;
}

?>
<?php $id = -1; foreach ($res as $row) :
    $id++; ?>
<form method="POST">
    <fieldset>
    <legend>Uppdatera</legend>
    <p>
        <label>Id: <br/>
            <input type="number" name="id" readonly value="<?= $row->id ?>"/>
        </label>
    </p>
    <p>
        <label>Titel: <br/>
            <input type="text" name="title" value="<?= $row->title ?>"/>
        </label>
    </p>
    <p>
        <label>Bild: <br/>
            <input type="text" name="image" value="<?= $row->image ?>"/>
        </label>
    </p>
    <p>
        <label>År: <br/>
            <input type="number" name="year" value="<?= $row->year ?>"/>
        </label>
    </p>
    <p>
        <input type="submit" name="update" value="Uppdatera">
    </p>
    </fieldset>
</form>
<?php endforeach; ?>
