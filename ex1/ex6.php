<?php

$inputFile = fopen("data/temperatures-sample.csv", "r");
$outputFile = fopen("data/temperatures.csv", "w");


$header = ["Year", "Month", "Day", "Hour", "Temperature"];
fputcsv($outputFile, $header);

while (!feof($inputFile)) {
$data = fgetcsv($inputFile);

if ($data !== false) {

$year = $data[0];
$month = $data[1];
$day = $data[2];
$hour = substr($data[3], 0, 2); //just the hour
$temperature = $data[9];


if (($year == 2004 || $year == 2022) && is_numeric($temperature)) {
// Write the filtered data to the output file
$filteredData = [$year, $month, $day, $hour, $temperature];
fputcsv($outputFile, $filteredData);
}
}
}

fclose($inputFile);
fclose($outputFile);

echo "Filtered data has been written to 'temperatures.csv'.";
