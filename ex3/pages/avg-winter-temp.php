<!DOCTYPE html>
<html lang="en">
<head>
    <base href="http://localhost:8080/ex3/">
    <meta charset="UTF-8">
    <title>Talve keskmine temperatuur</title>
    <link href="/ex3/pages/styles.css" rel="stylesheet">
</head>
<body>
<?php include 'menu.html' ?>

<h5>Milline oli valitud aastal talve keskmine temperatuur?</h5>

<form method="POST" action="temps.php">

    <table>
        <tr>
            <td><label for="year">Aasta</label>:</td>
            <td>
                <select name="year" id="year">
                    <option value="2020/2021">2020/2021</option>
                    <option value="2021/2022">2021/2022</option>
                </select>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>
                <br>
                <button type="submit" name="command"
                        value="avg-winter-temp">Arvuta</button>
            </td>
        </tr>
    </table>
</form>

</body>
</html>