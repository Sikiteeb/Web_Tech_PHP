<?php

include_once '../src/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $description = $_POST['description'] ?? '';
    $estimate = $_POST['estimate'] ?? '';
    $employeeId = $_POST['employeeId'] ?? null;
    $isCompleted = isset($_POST['isCompleted']) && $_POST['isCompleted'] == 'on' ? 1 : 0;

    $pdo = getConnection();

    $result = saveTask($description, $estimate, $isCompleted, $employeeId,$pdo);

    if ($result) {
        echo json_encode(['success' => true, 'message' => 'Task created successfully', 'taskId' => $result]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to create task']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}



