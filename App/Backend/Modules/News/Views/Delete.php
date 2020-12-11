<h1>Delete a News</h1>

<?php if(isset($alert)): ?>
    <h2><?= $alert ?></h2>
    <h3><?= $news->getTitle() ?></h2>
    <p><?= $news->getBody() ?></p>
    <?= $form ?>
<?php else: ?>
    <form action="" method="post">
        <label for="news">Select a news:</label>
            <select id="news" name="news">
                <?php foreach ($list as $news): ?>
                    <option value="<?= $news->getId() ?>"><?= $news->getTitle() ?></option>
                <?php endforeach; ?>
            </select>
            <input type="submit" value="Delete" />
    </form>
<?php endif; ?>