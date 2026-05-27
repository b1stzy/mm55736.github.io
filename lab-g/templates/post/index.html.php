<?php
$title = 'Post List';

ob_start();
?>
    <h1>Posts List</h1>

    <a href="<?= $router->generatePath('post-create') ?>">Create new</a>

    <ul class="index-list">
        <?php foreach ($posts as $post): ?>
            <li>
                <h3><?= htmlspecialchars($post->getSubject()) ?></h3>
                <ul class="action-list">
                    <li><a href="<?= $router->generatePath('post-show', ['id' => $post->getId()]) ?>">Details</a></li>
                    <li><a href="<?= $router->generatePath('post-edit', ['id' => $post->getId()]) ?>">Edit</a></li>
                </ul>
            </li>
        <?php endforeach; ?>
    </ul>

<?php
$page = ob_get_clean();
require __DIR__ . '/../base.html.php';
