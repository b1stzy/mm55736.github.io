<?php

require __DIR__ . '/lib/EncoderInterface.php';
require __DIR__ . '/lib/CsvEncoder.php';
require __DIR__ . '/lib/SsvEncoder.php';
require __DIR__ . '/lib/TsvEncoder.php';
require __DIR__ . '/lib/JsonEncoder.php';
require __DIR__ . '/lib/YamlEncoder.php';
require __DIR__ . '/lib/CookieManager.php';
require __DIR__ . '/lib/FormHandler.php';

$encoders = [
    new CsvEncoder(),
    new SsvEncoder(),
    new TsvEncoder(),
    new JsonEncoder(),
    new YamlEncoder(),
];

$cookieManager = new CookieManager();
$formHandler   = new FormHandler($encoders, $cookieManager);

$result = $formHandler->handleRequest();

$inputText    = $result['inputText'];
$inputFormat  = $result['inputFormat'];
$outputFormat = $result['outputFormat'];
$outputText   = $result['outputText'];

$formats = [
    'csv'  => 'CSV (comma)',
    'ssv'  => 'SSV (semicolon)',
    'tsv'  => 'TSV (tab)',
    'json' => 'JSON',
    'yaml' => 'YAML',
];

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Converter</title>
    <style>
        textarea { width: 100%; height: 200px; }
        pre { background: #eee; padding: 10px; white-space: pre-wrap; }
    </style>
</head>
<body>

<h1>Data Converter</h1>

<form method="post">
    <label>Input format:</label>
    <select name="input_format">
        <?php foreach ($formats as $key => $label): ?>
            <option value="<?= $key ?>" <?= $key === $inputFormat ? 'selected' : '' ?>>
                <?= $label ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label>Output format:</label>
    <select name="output_format">
        <?php foreach ($formats as $key => $label): ?>
            <option value="<?= $key ?>" <?= $key === $outputFormat ? 'selected' : '' ?>>
                <?= $label ?>
            </option>
        <?php endforeach; ?>
    </select>

    <br><br>

    <textarea name="input_text"><?= htmlspecialchars($inputText) ?></textarea>

    <br><br>

    <button type="submit">Convert</button>
</form>

<h2>Output</h2>
<pre><?= htmlspecialchars($outputText) ?></pre>

</body>
</html>
