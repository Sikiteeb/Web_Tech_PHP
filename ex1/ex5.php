<?php

$sampleData = [
    ['type' => 'apple', 'weight' => 0.21],
    ['type' => 'orange', 'weight' => 0.18],
    ['type' => 'pear', 'weight' => 0.16],
    ['type' => 'apple', 'weight' => 0.22],
    ['type' => 'orange', 'weight' => 0.15],
    ['type' => 'pear', 'weight' => 0.19],
    ['type' => 'apple', 'weight' => 0.09],
    ['type' => 'orange', 'weight' => 0.24],
    ['type' => 'pear', 'weight' => 0.13],
    ['type' => 'apple', 'weight' => 0.25],
    ['type' => 'orange', 'weight' => 0.08],
    ['type' => 'pear', 'weight' => 0.20],
];

function getAverageWeightsByType(array $list): array {
    $averages = [];
    $counts = [];

    // Iterate through the input data
    foreach ($list as $item) {
        $type = $item['type'];
        $weight = $item['weight'];


        if (!isset($averages[$type])) {
            $averages[$type] = $weight;
            $counts[$type] = 1;
        } else {
            $averages[$type] += $weight;
            $counts[$type]++;
        }
    }


    foreach ($averages as &$average) {
        $type = array_search($average, $averages);
        $count = $counts[$type];
        $average = round($average / $count, 2);
    }

    return $averages;
}

// Testing the function
print_r(getAverageWeightsByType($sampleData));
