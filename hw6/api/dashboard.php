<?php
error_reporting(E_ALL & ~E_DEPRECATED & ~E_USER_DEPRECATED);
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../src/functions.php';


$employees = getEmployeesWithTaskCount();
$tasks = getAllTasks();
foreach ($tasks as &$task) {
    $task['estimateDots'] = array_fill(0, $task['estimate'], 'filled');
    $task['estimateDots'] = array_pad($task['estimateDots'], 5, '');
}
unset($task);

$response = [
    'employees' => $employees,
    'tasks' => $tasks
];

header('Content-Type: application/json');
echo json_encode($response);
