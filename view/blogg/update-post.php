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
            <input type="hidden" name="id" readonly value="<?= $row->id ?>"/>
    <p>
        <label>Titel: <br/>
            <input type="text" name="title" value="<?= htmlentities($row->title) ?>"/>
        </label>
    </p>
    <p>
        <label>Path: <br/>
            <input type="text" name="path" value="<?= htmlentities($row->path) ?>"/>
        </label>
    </p>
    <p>
        <label>Slug: <br/>
            <input type="text" name="slug" value="<?= htmlentities($row->slug) ?>"/>
        </label>
    </p>
    <p>
        <label>Text: <br/>
            <textarea name="data" placeholder="Skriv din text här"/><?= htmlentities($row->data) ?></textarea>
        </label>
    </p>
    <p>
        <label>Type: <br/>
            <input type="text" name="type" value="<?= htmlentities($row->type) ?>"/>
        </label>
    </p>
    <p>
        <label>Filter: <br/>
            <input type="text" name="filter" value="<?= htmlentities($row->filter) ?>"/>
        </label>
    </p>
    <p>
        <label>Published: <br/>
            <input type="text" name="published" value="<?= htmlentities($row->published) ?>"/>
        </label>
    </p>
    <p>
        <input type="submit" name="update" value="Uppdatera">
    </p>
    </fieldset>
</form>
<?php endforeach; ?>
