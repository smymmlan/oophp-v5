<?php

namespace Anax\View;

if (!$res) {
    return;
}

?>

<article>
    <header>
        <h1><?= htmlentities($res->title) ?></h1>
        <p><i>Latest update: <time datetime="<?= htmlentities($res->modified_iso8601) ?>" pubdate><?= htmlentities($res->modified) ?></time></i></p>
    </header>
    <?= $res->data ?>
</article>
