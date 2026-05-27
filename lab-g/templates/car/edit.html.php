<?php
$title = "Edit Car";

ob_start();
?>
    <h1>Edit car</h1>

    <form method="post">
        <label>Brand</label>
        <input type="text" name="brand" value="<?= htmlspecialchars($car->getBrand()) ?>">

        <label>Model</label>
        <input type="text" name="model" value="<?= htmlspecialchars($car->getModel()) ?>">

        <label>Year</label>
        <input type="text" name="year" value="<?= $car->getYear() ?>">

        <button type="submit">Save</button>
    </form>

    <a href="?action=car-show&id=<?= $car->getId() ?>">Back</a>

<?php
$page = ob_get_clean();
require __DIR__ . '/../base.html.php';
