<?php

function getDaysUnderTemp(int $targetYear, float $targetTemp): float {
    $filename = __DIR__. '/data/temperatures-filtered.csv';
    $hoursBelowTemp = 0;

    if (($open = fopen($filename, "r")) !== FALSE) {
        fgetcsv($open);

        while (($data = fgetcsv($open)) !== FALSE) {
            $year = (int)$data[0];
            $temperature = (float)$data[4];

            if ($year === $targetYear) {

                if ($temperature <= $targetTemp) {
                    $hoursBelowTemp++;
                }
            }
        }

        fclose($open);

        $daysUnderTemp = round($hoursBelowTemp / 24.0, 2);

        return $daysUnderTemp;

    } else {
        return 0;
    }
}


function getAverageWinterTemperature(string $yearRange): float {
    $filename = __DIR__. '/data/temperatures-filtered.csv';
    $totalTemp = 0;
    $count = 0;

    [$startYear, $endYear] = explode('/', $yearRange);

    if (($open = fopen($filename, "r")) !== FALSE) {

        while (($data = fgetcsv($open)) !== FALSE) {
            $year = (int)$data[0];
            $month = (int)$data[1];
            $temperature = (float)$data[4];

            if (
                ($year == $startYear && $month == 12) ||
                ($year == $endYear && ($month == 1 || $month == 2))
            ) {
                $totalTemp += $temperature;
                $count++;
            }
        }

        fclose($open);

        return $count ? round($totalTemp / $count, 2) : 0;
    } else {
        return 0;

    }
}
