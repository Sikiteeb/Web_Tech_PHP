<?php

$list = [1, 2, 3];

function listToString(array $list): string {

    return '[' . join(', ', $list) . ']';
}

// Testing the function
$result = listToString([1, 2, 3]);
echo $result; // Should print "[1, 2, 3]"

