<?php

include_once '../src/functions.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $taskId = $_GET['id'];


    $taskData = getTaskById($taskId);

    if ($taskData) {
        echo json_encode(['success' => true, 'task' => $taskData]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Task not found']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
}



