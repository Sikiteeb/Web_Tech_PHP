<?php
require_once 'functions.php';

$temp = $_POST["temperature"] ?? "";

if (empty($temp)) {
    $message = "Insert temperature";
} else if (!is_numeric($temp)){
    $message = "Temperature must be a number";
} else {
    $message = sprintf("%s degrees in Fahrenheit is %d degrees in Celsius", $temp, f2c($temp));
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Fahrenheit to Celsius</title>
</head>
<body>

<nav>
    <a href="index.html">Celsius to Fahrenheit</a> |
    <a href="f2c.html">Fahrenheit to Celsius</a>
</nav>

<main>
    <h3>Fahrenheit to Celsius</h3>
    <em><?= $message ?></em>
</main>

</body>
</html>
