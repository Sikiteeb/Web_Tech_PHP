<?php

$projectRoot = $_SERVER['DOCUMENT_ROOT'] . '/';
include $projectRoot . 'ex1/ex7.php';
include $projectRoot .'/ex1/ex8.php';

putenv("PATH=" . "/usr/local/bin:" . getenv("PATH"));



// Check if we're running from the command line
if (php_sapi_name() == 'cli' && !debug_backtrace()) {

    if (!isset($argv)) {
        fwrite(STDERR, "No command-line arguments available!\n");
        exit(1);
    }

    $commandKey = array_search("--command", $argv);

    if ($commandKey === false || !isset($argv[$commandKey + 1])) {
        fwrite(STDERR, "Command not specified!\n");
        exit(1);
    }

    $command = $argv[$commandKey + 1];


// Handle each command separately
    switch ($command) {
        case "days-under-temp":
            $yearKey = array_search("--year", $argv);
            $tempKey = array_search("--temp", $argv);
            if ($yearKey !== false && isset($argv[$yearKey + 1]) && $tempKey !== false && isset($argv[$tempKey + 1])) {
                $year = intval($argv[$yearKey + 1]);
                $temperature = floatval($argv[$tempKey + 1]);
                echo getDaysUnderTemp($year, $temperature);
            } else {
                fwrite(STDERR, "Missing parameters! For 'days-under-temp' you must provide both --year and --temp.\n");
                exit(1);
            }
            break;

        case "days-under-temp-dict":
            $tempKey = array_search("--temp", $argv);
            if ($tempKey !== false && isset($argv[$tempKey + 1])) {
                $temperature = floatval($argv[$tempKey + 1]);
                $result = getDaysUnderTempDictionary($temperature);
                echo dictToString($result);
            } else {
                fwrite(STDERR, "Missing parameters! For 'days-under-temp-dict' you must provide --temp.\n");
                exit(1);
            }
            break;

        case "avg-winter-temp":
            $yearKey = array_search("--year", $argv);
            if ($yearKey !== false && isset($argv[$yearKey + 1])) {
                echo getAverageWinterTemperature($argv[$yearKey + 1]);
            } else {
                fwrite(STDERR, "Missing parameters! For 'avg-winter-temp' you must provide --year in format 'YYYY/YYYY'.\n");
                exit(1);
            }
            break;

        default:
            fwrite(STDERR, "Invalid command!\n");
            exit(1);
    }

}
echo PHP_EOL;

