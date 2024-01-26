<!DOCTYPE html>
<html lang="en">
<head>
    <base href="http://localhost:8080/ex3/">
    <meta charset="UTF-8">
    <title>Päevi alla valitud piiri</title>
    <link href="/ex3/pages/styles.css" rel="stylesheet">
</head>
<body>
<?php include 'menu.html' ?>

<h5>Mitu päeva oli valitud aastal temperatuur alla valitud piiri?</h5>

<form method="POST" action="temps.php">
    <table>
        <tr>
            <td><label for="year">Aasta</label>:</td>
            <td>
                <select name="year" id="year">
                    <option value="2020">2020</option>
                    <option value="2021">2021</option>
                    <option value="2022">2022</option>
                </select>
            </td>
        </tr>
        <tr>
            <td><label for="temp">Temperatuur</label>:</td>
            <td>
                <input type="number" name="temp" id="temp">
            </td>
        </tr>
        <tr>
            <td></td>
            <td>
                <br>
                <button type="submit" name="command"
                        value="days-under-temp">Arvuta</button>
            </td>
        </tr>
    </table>
</form>

</body>
</html>