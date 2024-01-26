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
    return null;
}

$response = ['success' => false, 'message' => ''];

try {
    $id = $_POST['id'] ?? null;
    $firstName = $_POST['firstName'] ?? '';
    $lastName = $_POST['lastName'] ?? '';
    $position = $_POST['position'] ?? '';
    $profilePicture = $_FILES['profile_picture'] ?? null;

    if (empty($firstName) || empty($lastName) || empty($id)) {
        throw new Exception('First name, last name, and ID are required.');
    }

    $pdo = getConnection();
    $currentEmployeeData = getEmployeeById($id, $pdo);

    if (!$currentEmployeeData) {
        throw new Exception('Employee not found.');
    }

    $profilePicturePath = processUploadedFile($profilePicture);
    if (!$profilePicturePath) {
        $profilePicturePath = $currentEmployeeData['profile_picture'];
    }

    $updateSuccess = updateEmployee($id, $firstName, $lastName, $position, $profilePicturePath, $pdo);

    if ($updateSuccess) {
        $response = ['success' => true, 'message' => 'Employee updated successfully'];
    } else {
        throw new Exception('Failed to update the employee.');
    }
} catch (Exception $e) {
    $response = ['success' => false, 'message' => $e->getMessage()];
}

header('Content-Type: application/json');
echo json_encode($response);

