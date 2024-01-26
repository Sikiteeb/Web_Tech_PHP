<?php

function getDaysUnderTempDictionary(float $targetTemp): array {
    $filename = __DIR__. '/data/temperatures-filtered.csv';
    $yearlyHours = [];
    if (($open = fopen($filename, "r")) !== FALSE) {
        fgetcsv($open); // skip header row

        while (($data = fgetcsv($open)) !== FALSE) {
            $year = (int)$data[0];
            $temperature = (float)$data[4];

            if ($temperature <= $targetTemp) {
                if (!isset($yearlyHours[$year])) {
                    $yearlyHours[$year] = 0;
                }
                $yearlyHours[$year]++;
            }
        }

        fclose($open);


        foreach ($yearlyHours as $year => $hours) {
            $yearlyHours[$year] = round($hours / 24.0, 2);
        }

        return $yearlyHours;

    } else {
        return [];
    }
}

function dictToString(array $dict): string {
    $parts = [];
    foreach ($dict as $year => $days) {
        $parts[] = "$year => $days";
    }
    return "[" . implode(', ', $parts) . "]";
}

