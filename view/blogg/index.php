<?php

namespace Anax\View;

if (!$res) {
    return;
}

?>


<table class="blogg-table">
    <tr class="first">
        <th>Id</th>
        <th>Path</th>
        <th>Slug</th>
        <th>Title</th>
        <th>Published</th>
        <th>Updated</th>
        <th>Created</th>
        <th>Deleted</th>
    </tr>
<?php $id = -1; foreach ($res as $row) :
    $id++; ?>
    <tr>
        <td><?= htmlentities($row->id) ?></td>
        <td><?= htmlentities($row->path) ?></td>
        <td><?= htmlentities($row->slug) ?></td>
        <td><?= htmlentities($row->title) ?></td>
        <td><?= htmlentities($row->published) ?></td>
        <td><?= htmlentities($row->updated) ?></td>
        <td><?= htmlentities($row->created) ?></td>
        <td><?= htmlentities($row->deleted) ?></td>
    </tr>
<?php endforeach; ?>
</table>
