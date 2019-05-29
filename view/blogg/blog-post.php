<?php

namespace Anax\View;

if (!$res) {
    return;
}

?>

<article>
    <header>
        <h1><?= htmlentities($res->title) ?></h1>
        <p><i>Published: <time datetime="<?= htmlentities($res->published_iso8601) ?>" pubdate><?= htmlentities($res->published) ?></time></i></p>
    </header>
    <?= $res->data ?>
</article>
