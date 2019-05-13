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
    <legend>Radera</legend>
    <p>
        <label>Id: <br/>
            <input type="number" name="id" readonly value="<?= $row->id ?>"/>
        </label>
    </p>
    <p>
        <label>Titel: <br/>
            <input type="text" name="title" readonly value="<?= $row->title ?>"/>
        </label>
    </p>
    <p>
        <label>Bild: <br/>
            <input type="text" name="image" readonly value="<?= $row->image ?>"/>
        </label>
    </p>
    <p>
        <label>År: <br/>
            <input type="number" name="year" readonly value="<?= $row->year ?>"/>
        </label>
    </p>
    <p>
        <input type="submit" name="delete" value="Radera">
    </p>
    </fieldset>
</form>
<?php endforeach; ?>
