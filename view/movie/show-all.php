<?php

namespace Anax\View;

if (!$res) {
    return;
}

?>

<table class="movie-table">
    <tr class="first">
        <th>Rad</th>
        <th>Id</th>
        <th>Bild</th>
        <th>Titel</th>
        <th>År</th>
        <th class="delete-icon">Uppdatera</th>
        <th class="delete-icon">Radera</th>
    </tr>
<?php $id = -1; foreach ($res as $row) :
    $id++; ?>
    <tr>
        <td><?= $id ?></td>
        <td><?= $row->id ?></td>
        <td><img class="thumb" src="../<?= $row->image ?>"></td>
        <td><?= $row->title ?></td>
        <td><?= $row->year ?></td>
        <td class="update-icon"><a href="update-movie/<?= $row->id ?>">&#9997;</a></td>
        <td class="delete-icon"><a href="delete-movie/<?= $row->id ?>">&#128465;</a></td>
    </tr>
<?php endforeach; ?>
</table>
