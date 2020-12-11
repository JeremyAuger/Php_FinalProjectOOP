
<h1>News: <?= $title ?></h1>

<?= ($user->hasFlash())? '<h2>'.$user->getFlash().'</h2>' : ''; ?>


<?= $form; ?>