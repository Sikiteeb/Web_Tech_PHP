<?php

require_once 'functions.php';

$input = $_POST['temperature'] ?? null;

$inputTemp = floatval($input);

$result = c2f($inputTemp);

if (empty($input)) {
    $message = "Insert temperature";
} else if (!is_numeric($inputTemp)){
    $message = "Temperature must be an integer";
} else {
    $inputTemp = intval($input);

    $result = c2f($inputTemp);

    $message = sprintf("%d degrees in Celsius is %d degrees in Fahrenheit",
        $inputTemp, $result);
}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Celsius to Fahrenheit</title>
</head>
<body>

<nav>
    <a id="c2f" href="index.html">Celsius to Fahrenheit</a> |
    <a id="f2c" href="f2c.html">Fahrenheit to Celsius</a>
</nav>

<main>

    <h3>Celsius to Fahrenheit</h3>
    <em><?= $message ?></em>

</main>

</body>
</html>
