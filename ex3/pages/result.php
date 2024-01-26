<?php
$result = $_SESSION['result'] ?? 'No result found.';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tulemus</title>
    <link href="/ex3/pages/styles.css" rel="stylesheet">
</head>
<body>

<?php include 'menu.html' ?>

<h5>Vastus:</h5>

<?php print $result; ?>

</body>
</html>