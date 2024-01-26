<?php
session_start();
ini_set('display_errors', '1');

$projectRoot = $_SERVER['DOCUMENT_ROOT'] . '/';
include $projectRoot . 'ex1/ex7.php';
include $projectRoot . 'ex1/ex8.php';

$command = $_GET['command'] ?? $_POST['command'] ?? 'show-form';
$page = $_GET['page'] ?? '';


switch ($command) {
    case 'show-form':
        if ($page === 'days-under-temp' || empty($page)) {
            include 'pages/days-under-temp.php';
        } elseif ($page === 'avg-winter-temp') {
            include 'pages/avg-winter-temp.php';
        } else {
            include 'pages/menu.html';
        }
        break;

    case "days-under-temp":
        if (isset($_POST['year']) && isset($_POST['temp'])) {
            $year = intval($_POST['year']);
            $temperature = floatval($_POST['temp']);
            $result = getDaysUnderTemp($year, $temperature);
            $_SESSION['result'] = $result;

            include 'pages/result.php';
        } else {
            echo "Missing parameters! For 'days-under-temp' you must provide both year and temp.";
        }
        break;

    case "avg-winter-temp":
        if (isset($_POST['year'])) {
            $result = getAverageWinterTemperature($_POST['year']);
            $_SESSION['result'] = $result;
            include 'pages/result.php';
        } else {
            echo "Missing parameters! For 'avg-winter-temp' you must provide year in format 'YYYY/YYYY'.";
        }
        break;

        default:
        echo "Unknown command: " . htmlspecialchars($command);
        break;
}
