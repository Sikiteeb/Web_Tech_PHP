<?php

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

function saveEmployee($firstName, $lastName, $position, $profile_picture, PDO $pdo) {
    try {
        $sql = 'INSERT INTO employees (firstName, lastName, position, profile_picture) 
                VALUES (:firstName, :lastName, :position, :profile_picture)';
        $stmt = $pdo->prepare($sql);

        $stmt->bindValue(':firstName', $firstName, PDO::PARAM_STR);
        $stmt->bindValue(':lastName', $lastName, PDO::PARAM_STR);
        $stmt->bindValue(':position', $position, PDO::PARAM_STR);
        $stmt->bindValue(':profile_picture', $profile_picture, PDO::PARAM_STR);

        $stmt->execute();

        return $pdo->lastInsertId();
    } catch (PDOException $e) {

        error_log('Save Employee Error: ' . $e->getMessage());
        return 0;
    }
}

function saveTask($description, $estimate, $isCompleted, $employeeId, PDO $pdo) {
    $sql = "INSERT INTO tasks (description, estimate, isCompleted, employeeId) VALUES (:description, :estimate, :isCompleted, :employeeId)";
    $stmt = $pdo->prepare($sql);

    // Bind the parameters to the prepared statement
    $stmt->bindValue(":description", $description);
    $stmt->bindValue(":estimate", $estimate);
    $stmt->bindValue(":isCompleted", $isCompleted, PDO::PARAM_BOOL);
    $stmt->bindValue(":employeeId", $employeeId, PDO::PARAM_INT);

    if ($stmt->execute()) {
        return [
            'success' => true,
            'message' => 'Task successfully saved',
            'taskId' => $pdo->lastInsertId()
        ];
    } else {
        return [
            'success' => false,
            'message' => 'Failed to save task'
        ];
    }
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
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
function getEmployeeById($employeeId) {
    $pdo = getConnection();
    $stmt = $pdo->prepare('SELECT * FROM employees WHERE id = :id');
    $stmt->execute(['id' => $employeeId]);
    $employee = $stmt->fetch(PDO::FETCH_ASSOC);
    return $employee;
}
function getEmployeeDisplayData($id, $firstName, $lastName, $position, $profile_picture = 'missing.png') {
    $filePath = __DIR__ . '/hw6/public/img/' . $profile_picture;

    $imageURL = '/hw6/public/img/' . $profile_picture;
    if (!file_exists($filePath) || $profile_picture == 'missing.png') {
        $imageURL = '/hw6/public/img/missing.png';
    }

    $editLink = "index.php?cmd=employee-form&id=" . urlencode($id);
    $formattedPosition = ucwords($position);

    return [
        'id' => $id,
        'firstName' => $firstName,
        'lastName' => $lastName,
        'profile_picture' => $imageURL,
        'editLink' => $editLink,
        'position' => $formattedPosition,
    ];
}

function getEmployeesWithTaskCount() {
    $pdo = getConnection();
    $query = '
        SELECT employees.id, CONCAT_WS(" ", employees.firstName, employees.lastName) AS name, employees.position, employees.profile_picture, 
        COUNT(IF(tasks.isCompleted = 0, 1, NULL)) as task_count 
        FROM employees 
        LEFT JOIN tasks ON employees.id = tasks.employeeId 
        GROUP BY employees.id';
    $stmt = $pdo->query($query);
    $employees = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($employees as &$employee) {
        $imagePath = "/public/img/" . $employee['profile_picture'];
        if (!file_exists($_SERVER['DOCUMENT_ROOT'] . $imagePath) || $employee['profile_picture'] == '') {
            $employee['profile_picture'] = "missing.png";
        }
    }
    unset($employee);

    return $employees;
}
function updateTask($id, $description, $estimate, $isCompleted, $employeeId, PDO $pdo) {
    $sql = "UPDATE tasks SET description = :description, estimate = :estimate, isCompleted = :isCompleted, employeeId = :employeeId WHERE id = :id";
    $stmt = $pdo->prepare($sql);

    // Bind the parameters to the prepared statement
    $stmt->bindValue(":id", $id, PDO::PARAM_INT);
    $stmt->bindValue(":description", $description);
    $stmt->bindValue(":estimate", $estimate, PDO::PARAM_INT);
    $stmt->bindValue(":isCompleted", $isCompleted, PDO::PARAM_BOOL);
    $stmt->bindValue(":employeeId", $employeeId, PDO::PARAM_INT);


    if ($stmt->execute()) {
        return [
            'success' => true,
            'message' => 'Task successfully updated'
        ];
    } else {
        return [
            'success' => false,
            'message' => 'Failed to update task'
        ];
    }
}
function updateEmployee($id, $firstName, $lastName, $position, $profile_picture) {
    $pdo = getConnection();

    $sql = "UPDATE employees SET firstName = :firstName, lastName = :lastName, position = :position, profile_picture = :profile_picture WHERE id = :id";
    $stmt = $pdo->prepare($sql);

    try {
        $stmt->execute([
            ':id' => $id,
            ':firstName' => $firstName,
            ':lastName' => $lastName,
            ':position' => $position,
            ':profile_picture' => $profile_picture
        ]);
        return true;
    } catch (PDOException $e) {
        return false;
    }
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
        'editLink' => "?cmd=task-form&id=$id",
        'isCompleted' => $isCompleted
    ];
}







