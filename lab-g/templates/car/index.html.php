<?php
$title = "Cars";

ob_start();
?>
    <div class="car-list">
        <h1>Cars</h1>

        <ul class="action-list">
            <li><a href="?action=car-create">Add new car</a></li>
        </ul>

        <ul>
            <?php foreach ($cars as $car): ?>
                <li>
                    <a href="?action=car-show&id=<?= $car->getId() ?>">
                        <?= htmlspecialchars($car->getBrand()) ?>
                        <?= htmlspecialchars($car->getModel()) ?>
                        (<?= $car->getYear() ?>)
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php
$page = ob_get_clean();
require __DIR__ . '/../base.html.php';
