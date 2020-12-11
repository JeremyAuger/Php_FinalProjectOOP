
<h1><?= $title ?></h1>

<!-- Display the last News -->
<?php foreach ($list as $news): ?>
    <article>
        <h2><a href="/news-<?= $news['id'] ?>.html"><?= $news['title'] ?></a></h2>
        <p>
            <?php if (isset($news['modification_date'])) : ?>
                Updated by: <?= $news['author'] ?> the <?= $news->getModification_dateFormated() ?>
            <?php else : ?>
                Published by: <?= $news['author'] ?> the <?= $news->getPublication_dateFormated() ?>
            <?php endif; ?>
        </p>
    </article>
<?php endforeach ?>