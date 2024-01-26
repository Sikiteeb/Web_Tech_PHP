<?php

$sets = distributeToSets([1, 2, 1]);

//var_dump($sets);

function distributeToSets(array $input): array {
    $sets = [];

    foreach ($input as $each) {
        if (isset($sets[$each])) {
            $sets[$each][] = $each; //adds element, no position, at the end
        } else {
            $sets[$each] = [$each];
        }
    }

    return $sets;
}
