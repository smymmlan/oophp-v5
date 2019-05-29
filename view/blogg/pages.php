<?php

namespace Anax\View;

if (!$res) {
    return;
}

?>


<table class="blogg-table-pages">
    <tr class="first">
        <th>Id</th>
        <th>Title</th>
        <th>Type</th>
        <th>Status</th>
        <th>Published</th>
        <th>Deleted</th>
    </tr>
<?php $id = -1; foreach ($res as $row) :
    $id++; ?>
    <tr>
        <td><?= htmlentities($row->id) ?></td>
        <td><a href="page/<?= htmlentities($row->title) ?>"><?= htmlentities($row->title) ?></a></td>
        <td><?= htmlentities($row->type) ?></td>
        <td><?= htmlentities($row->status) ?></td>
        <td><?= htmlentities($row->published) ?></td>
        <td><?= htmlentities($row->deleted) ?></td>
    </tr>
<?php endforeach; ?>
</table>
