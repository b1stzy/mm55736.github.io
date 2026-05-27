<?php
$title = 'Post Details';

ob_start();
?>
    <h1><?= htmlspecialchars($post->getSubject()) ?></h1>

    <p><?= nl2br(htmlspecialchars($post->getBody())) ?></p>

    <ul class="action-list">
        <li><a href="<?= $router->generatePath('post-edit', ['id' => $post->getId()]) ?>">Edit</a></li>
        <li><a href="<?= $router->generatePath('post-index') ?>">Back</a></li>
    </ul>

<?php
$page = ob_get_clean();
require __DIR__ . '/../base.html.php';
