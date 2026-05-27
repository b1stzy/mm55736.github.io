<?php
$title = "Add Car";

ob_start();
?>
    <h1>Add new car</h1>

    <form method="post">
        <label>Brand</label>
        <input type="text" name="brand">

        <label>Model</label>
        <input type="text" name="model">

        <label>Year</label>
        <input type="text" name="year">

        <button type="submit">Save</button>
    </form>

    <a href="?action=car-index">Back</a>

<?php
$page = ob_get_clean();
require __DIR__ . '/../base.html.php';
