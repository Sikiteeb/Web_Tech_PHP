<?php

include_once __DIR__ . '/../src/functions.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$estimates = [1, 2, 3, 4, 5];
$employees = getAllEmployees();

$isEditAction = !empty($_GET['id']);
$responseData = [
    'estimates' => $estimates,
    'employees' => $employees,
    'isEditAction' => $isEditAction,
    'task' => null,
    'error' => ''
];

if ($isEditAction) {
    $task = getTaskById($_GET['id']);
    if ($task) {
        $responseData['task'] = $task;
        $responseData['task']['isCompleted'] = ($task['status'] === 'closed');
    } else {
        $responseData['error'] = "Task not found.";
        sendJsonResponse($responseData, 404);
        exit;
    }
} else {
    $responseData['task'] = [
        'description' => '',
        'estimates' => 1,
        'employeeId' => null,
        'isCompleted' => false,
        'id' => null
    ];
}

if (isset($_SESSION['formData'])) {
    $responseData['task'] = array_merge($responseData['task'], $_SESSION['formData']);
    unset($_SESSION['formData']);
}

if (isset($_SESSION['error'])) {
    $responseData['error'] = $_SESSION['error'];
    unset($_SESSION['error']);
}

sendJsonResponse($responseData);
