<?php

const PROJECT_DIRECTORY = __DIR__ . '/Users/sigridhanni/PhpstormProjects/icd0007';

$numbers = [1, 2, '3', 6, 2, 3, 2, 3];

$count = 0;

foreach ($numbers as $number) {
    if ($number === 3) {
        $count++;
    }
}

echo "Found it $count times";
