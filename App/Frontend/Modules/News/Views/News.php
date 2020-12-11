<!-- Display the News -->
<article>
    <h1><?= $news['title'] ?></h1>
        <p><?= $news['body'] ?></p>
    <footer>
        <?php if (isset($news['modification_date'])) : ?>
            Updated by: <?= $news['author'] ?> the <?= $news->getModification_dateFormated() ?>
        <?php else : ?>
            Published by: <?= $news['author'] ?> the <?= $news->getPublication_dateFormated() ?>
        <?php endif; ?>
    </footer>
</article>

<!-- Link post a comment -->
<a href="comment-news=<?= $news['id'] ?>.html">Post a Comment</a>

<!-- Display comments -->
<article>
    <?php foreach ($comments as $comment): ?>
        <p><?= $comment['body'] ?></p>
        <footer>
            <p>
                <?php if (isset($comment['modification_date'])) : ?>
                    Updated by: <?= $comment['author'] ?> the <?= $comment->getModification_dateFormated() ?>
                <?php else : ?>
                    Published by: <?= $comment['author'] ?> the <?= $comment->getPublication_dateFormated() ?>
                <?php endif; ?>
            </p>
            <div>
                <?php if($user->isAuthenticated()): ?>
                    <a href="/admin/comments=<?= $comment['id'] ?>.html">Modify</a>
                <?php endif; ?>
            </div>
        </footer>
    <?php endforeach; ?>
</article>

