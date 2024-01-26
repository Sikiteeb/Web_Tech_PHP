<?php


ini_set('display_errors', 1);
error_reporting(E_ALL);

include_once __DIR__ . '/../src/functions.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

function processUploadedFile($file) {
    if ($file && $file['error'] == UPLOAD_ERR_OK) {
        $uploadDir = __DIR__ . '/../public/img/';
        $fileName = basename($file['name']);
        $filePath = $uploadDir . uniqid() . '_' . $fileName;
        if (move_uploaded_file($file['tmp_name'], $filePath)) {
            return $filePath;
        }
    }
    return 'missing.png';
}

$response = ['success' => false, 'message' => ''];

try {
    $firstName = $_POST['firstName'] ?? '';
    $lastName = $_POST['lastName'] ?? '';
    $position = $_POST['position'] ?? '';
    $profilePicture = $_FILES['profile_picture'] ?? null;

    if (empty($firstName) || empty($lastName)) {
        throw new Exception('First name and last name are required.');
    }

    $profilePicturePath = processUploadedFile($profilePicture);

    $pdo = getConnection();
    $result = saveEmployee($firstName, $lastName, $position, $profilePicturePath, $pdo);

    if ($result) {
        $response = ['success' => true, 'message' => 'Employee created successfully', 'employeeId' => $result];
    } else {
        throw new Exception('Failed to create the employee.');
    }
} catch (Exception $e) {
    $response = ['success' => false, 'message' => $e->getMessage()];
}

    header('Content-Type: application/json');
    echo json_encode($response);

