<?php
error_reporting(E_ALL & ~E_DEPRECATED & ~E_USER_DEPRECATED);

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../../vendor/autoload.php';
include_once __DIR__ . '/../src/functions.php';

$tasks = getAllTasks();
$tasksDisplayData = [];

foreach ($tasks as $task) {
    $tasksDisplayData[] = getTaskDisplayData(
        $task['id'],
        $task['description'],
        $task['status'],
        $task['estimate'],
        $task['isCompleted']
    );
}


header('Content-Type: application/json');
echo json_encode($tasksDisplayData);
exit;
