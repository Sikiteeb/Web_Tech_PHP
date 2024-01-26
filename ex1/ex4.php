<?php

$input = '[1, 4, 2, 0]';

function stringToIntegerList(string $input): array {
    $input = str_replace(['[', ']'], '', $input);

    $elements = explode(', ', $input);


    $integerList = [];

    foreach ($elements as $element) {
        $integerList[] = intval($element);
    }

    return $integerList;
}

// Testing the function
$list = stringToIntegerList('[1, 4, 2, 0]');
var_dump($list === [1, 4, 2, 0]); // Should print "bool(true)"
