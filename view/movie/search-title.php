<?php

namespace Anax\View;

?>
<form method="POST">
    <fieldset>
    <legend>Search Title</legend>
    <p>
        <label>Title:
            <input type="search" name="searchTitle"/>
        </label>
    </p>
    <p>
        <input type="submit" name="searchBtn" value="Search">
    </p>
    </fieldset>
</form>

<?php

if (isset($res)) {
    ?><table class="movie-table">
        <tr class="first">
            <th>Rad</th>
            <th>Id</th>
            <th>Bild</th>
            <th>Titel</th>
            <th>År</th>
        </tr>
    <?php $id = -1; foreach ($res as $row) :
        $id++; ?>
        <tr>
            <td><?= $id ?></td>
            <td><?= $row->id ?></td>
            <td><img class="thumb" src="../<?= $row->image ?>"></td>
            <td><?= $row->title ?></td>
            <td><?= $row->year ?></td>
        </tr>
    <?php endforeach; ?>
    </table>
<?php } ?>
