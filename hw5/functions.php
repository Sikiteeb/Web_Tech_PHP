<?php
require_once '../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(PROJECT_ROOT);
$dotenv->load();

define('PROJECT_ROOT', realpath(dirname(__FILE__)));

function getConnection(): PDO {
    $host = $_ENV['DB_HOST'];
    $username = $_ENV['DB_USERNAME'];
    $password = $_ENV['DB_PASSWORD'];
    $dbname = $_ENV['DB_NAME'];

    $address = sprintf('mysql:host=%s;port=3306;dbname=%s', $host, $dbname);

    return new PDO($address, $username, $password);
}


function getAllTasks() {
    $pdo = getConnection();
    $stmt = $pdo->prepare('SELECT * FROM tasks');
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
function getAllEmployees() {
    $pdo = getConnection();
    $stmt = $pdo->prepare('SELECT id, firstName, lastName, position, profile_picture FROM employees ORDER BY firstName');
    $stmt->execute();
    $employees = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($employees as &$employee) {
        if (empty($employee['profile_picture'])) {
            $employee['profile_picture'] = '/static/img/missing.png';
        } else {
            $employee['profile_picture'] = "/static/img/" . $employee['profile_picture'];
        }
    }
    return $employees;
}
function getEmployeeById($employeeId) {
    $pdo = getConnection();
    $stmt = $pdo->prepare('SELECT * FROM employees WHERE id = :id');
    $stmt->execute(['id' => $employeeId]);
    $employee = $stmt->fetch(PDO::FETCH_ASSOC);
    return $employee;
}
function getEmployeeDisplayData($id, $firstName, $lastName, $position, $profile_picture = '../static/img/'): array
{
    if (empty($profile_picture) || $profile_picture == '../static/img/') {
        $profile_picture = 'missing.png';
    }
    $editLink = "index.php?cmd=employee-form&id=" . urlencode($id);

    $formattedPosition = ucwords($position);

    return [
        'id'            => $id,
        'firstName'     => $firstName,
        'lastName'      => $lastName,
        'profile_picture' => $profile_picture,
        'editLink'      => $editLink,
        'position'      => $formattedPosition,
    ];
}
function getEmployeesWithTaskCount(): array {
    $pdo = getConnection();
    $query = '
        SELECT employees.id, CONCAT_WS(" ", employees.firstName, employees.lastName) AS name, employees.position, employees.profile_picture, 
        COUNT(IF(tasks.isCompleted = 0, 1, NULL)) as task_count 
        FROM employees 
        LEFT JOIN tasks ON employees.id = tasks.employeeId 
        GROUP BY employees.id';
    $stmt = $pdo->query($query);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
function getTaskById($taskId) {
    $pdo = getConnection();
    $stmt = $pdo->prepare('SELECT * FROM tasks WHERE id = :id');
    $stmt->execute(['id' => $taskId]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
function getTaskDisplayData($id, $description, $status, $estimateValue, $isCompleted) {
    $estimateDots = [];

    for ($i = 0; $i < 5; $i++) {
        $estimateDots[] = $i < $estimateValue? 'filled' : '';
    }
    return [
        'id' => $id,
        'description' => $description,
        'status' => $status,
        'estimate' => $estimateDots,
        'editLink' => "?cmd=task-form&id={$id}",
        'isCompleted' => $isCompleted
    ];
}




