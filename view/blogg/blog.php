<?php

namespace Anax\View;

if (!$res) {
    return;
}

?>

<article>
<?php foreach ($res as $row) : ?>
<section>
    <header>
        <h1><a href="blog-post/<?= htmlentities($row->slug) ?>"><?= htmlentities($row->title) ?></a></h1>
        <p><i>Published: <time datetime="<?= htmlentities($row->published_iso8601) ?>" pubdate><?= htmlentities($row->published) ?></time></i></p>
    </header>
    <p><?= $row->data ?></p>
</section>
<?php endforeach; ?>

</article>
