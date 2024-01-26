<?php

$list = [1, 2, 3, 2, 6];

function isInList($list, $elementToBeFound): bool {
    for ($i = 0; $i < count($list); $i++) {
        if ($list[$i] === $elementToBeFound) {
            return true;
        }
    }
    return false;
}

// Testing the function
var_dump(isInList([1, 2, 3], 2)); // Should return true
var_dump(isInList([1, 2, 3], 4)); // Should return false
var_dump(isInList([1, 2, 3], '2')); // Should return false
