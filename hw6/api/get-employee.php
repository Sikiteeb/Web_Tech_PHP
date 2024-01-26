<?php

include_once '../src/functions.php';

$employeeId = $_GET['id'] ?? null;

if ($employeeId) {
    $employeeData = getEmployeeById($employeeId);
    if ($employeeData) {
        echo json_encode($employeeData);
    } else {
        echo json_encode(['error' => 'Employee not found']);
    }
} else {
    echo json_encode(['error' => 'No employee ID provided']);
}

exit;

