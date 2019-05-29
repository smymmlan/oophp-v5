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
            <input type="text" name="id" readonly value="<?= htmlentities($row->id) ?>"/>
        </label>
    </p>
    <p>
        <label>Titel: <br/>
            <input type="text" name="title" readonly value="<?= htmlentities($row->title) ?>"/>
        </label>
    </p>
    <p>
        <label>Slug: <br/>
            <input type="text" name="slug" readonly value="<?= htmlentities($row->slug) ?>"/>
        </label>
    </p>
    <p>
        <label>Publiserad: <br/>
            <input type="text" name="published" readonly value="<?= htmlentities($row->published) ?>"/>
        </label>
    </p>
    <p>
        <input type="submit" name="delete" value="Radera">
    </p>
    </fieldset>
</form>
<?php endforeach; ?>
