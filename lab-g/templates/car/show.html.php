<?php
$title = "Car Details";

ob_start();
?>
    <h1><?= htmlspecialchars($car->getBrand()) ?> <?= htmlspecialchars($car->getModel()) ?></h1>

    <p><strong>Year:</strong> <?= $car->getYear() ?></p>

    <ul class="action-list">
        <li><a href="?action=car-edit&id=<?= $car->getId() ?>">Edit</a></li>
        <li><a href="?action=car-delete&id=<?= $car->getId() ?>">Delete</a></li>
        <li><a href="?action=car-index">Back</a></li>
    </ul>

<?php
$page = ob_get_clean();
require __DIR__ . '/../base.html.php';
