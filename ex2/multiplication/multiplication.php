<?php

print file_get_contents('table-header.html');

// Sample code to generate contents.
// Make the data tabular by inserting <table>,
// <tr> and <td> tags to the correct positions.

print '<table border="1">';

foreach (range(0,9) as $first) {
    if ($first === 0 || $first === 5) {
        print'<tr>';
    }

    print'<td>';
    foreach (range(0, 9) as $second) {
        $result = $first * $second;
        print("$first x $second = $result" . "<br>" . PHP_EOL);
    }
    print '</td>';
    if ($first === 4 ||$first === 9) {
        print '</tr>';
    }

}
print '</table>';
print file_get_contents('table-footer.html');
