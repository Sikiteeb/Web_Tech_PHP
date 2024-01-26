<?php

include_once '../src/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;
    $description = $_POST['description'] ?? '';
    $estimate = $_POST['estimate'] ?? '';
    $employeeId = $_POST['employeeId'] ?? null;
    $isCompleted = isset($_POST['isCompleted']) ? 1 : 0;

    $pdo = getConnection();
    $result = updateTask($id, $description, $estimate, $isCompleted, $employeeId, $pdo);

    if ($result) {
        echo json_encode(['success' => true, 'message' => 'Task updated successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update task']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}






