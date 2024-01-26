<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../ex5/connection.php';
define('PROJECT_ROOT', realpath(dirname(__FILE__)));


function getAllTasks() {
    $pdo = getConnection();
    $stmt = $pdo->prepare('SELECT * FROM tasks');
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
function getAllEmployees() {
    $pdo = getConnection();
    $stmt = $pdo->prepare('SELECT * FROM employees ORDER BY firstName');
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getEmployeeById($employeeId) {
    $pdo = getConnection();
    $stmt = $pdo->prepare('SELECT * FROM employees WHERE id = :id');
    $stmt->execute(['id' => $employeeId]);
    $employee = $stmt->fetch(PDO::FETCH_ASSOC);
    return $employee;
}
function getTaskDetails($taskId) {
    $taskId = trim($taskId);

    $fileContent = file_get_contents('tasks.txt');
    if ($fileContent === false) {
        return false;
    }

    $splitTasks = explode("\n", $fileContent);

    foreach ($splitTasks as $serializedTask) {
        $currentTask = unserialize($serializedTask);

        if (isset($currentTask['id']) && $currentTask['id'] === $taskId) {
            return [
                'id' => $currentTask['id'],
                'description' => $currentTask['description'],
                'estimate' => $currentTask['estimate'],
                'status' => $currentTask['status']
            ];
        }
    }

    return false;
}
function getEmployeeDetails($employeeId) {

    $employeeId = trim($employeeId);

    $employees = file("employees.txt", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    if ($employees === false) {
        return false;
    }

    foreach ($employees as $employee) {
        $employeeData = explode(",", $employee);
        if (count($employeeData) >= 5) {
            list($id, $firstName, $lastName, $position, $picture) = $employeeData;

            if ($id === $employeeId) {
                return [
                    'id' => $id,
                    'firstName' => $firstName,
                    'lastName' => $lastName,
                    'position' => $position,
                    'profile_picture' => $picture
                ];
            }
        }
    }

    return false;
}


function displayEmployee($id, $firstName, $lastName, $position, $photoPath = 'static/img/default.png') {
    $fullName = ($firstName) . ' ' . ($lastName);

    echo '<div class="employee-item">';
    echo '<img class="employee-photo" src="' . htmlspecialchars($photoPath) . '" alt="Profile picture of ' . htmlspecialchars($fullName) . '" data-employee-id="' . $id . '"/>';
    echo '<span class="name" data-employee-id="' . $id . '">' . htmlspecialchars($fullName) . '</span>';
    echo '<span class="link"><a id="employee-edit-link-' . $id . '" href="navigation.php?cmd=employee-form&id=' . $id . '">Edit</a></span>';
    echo '<br><span class="position">' . ucwords($position) . '</span>';
    echo '</div>';
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

function displayTask($id, $description, $status, $estimate) {
    $statusClass = strtolower($status);
    $capitalizedStatus = ucfirst($status);

    $dots = '';
    for ($i = 0; $i < 5; $i++) {
        $dots .= $i < $estimate ? '<div class="dot filled"></div>' : '<div class="dot"></div>';
    }

    echo '<div class="task ' . $statusClass . '">
            <span class="link"><a id="task-edit-link-' .$id.'" href="?cmd=task-form&id=' . $id . '">Edit</a></span>
            <div class="title">
                <div data-task-id="' . $id . '">' . $description . '</div>
            </div>
            <br>
            <div id="task-state-' . $id . '" class="status ' . $statusClass . '">' . $capitalizedStatus . '</div>
            ' . $dots . '
        </div>';
}




