<?php
$title = 'Create Post';

ob_start();
?>
    <h1>Create Post</h1>

    <form method="post">
        <?php require __DIR__ . '/_form.html.php'; ?>
    </form>

    <a href="<?= $router->generatePath('post-index') ?>">Back</a>

<?php
$page = ob_get_clean();
require __DIR__ . '/../base.html.php';
