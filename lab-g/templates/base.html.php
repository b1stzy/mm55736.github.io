<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?? 'Site' ?></title>
    <link rel="stylesheet" href="/assets/dist/style.min.css">
</head>
<body>

<?php require __DIR__ . '/post/nav.html.php'; ?>

<main>
    <?= $page ?? '' ?>
</main>

<footer>&copy;<?= date('Y') ?> Custom Framework</footer>

</body>
</html>
