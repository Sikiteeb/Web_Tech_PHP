<?php

include_once '../src/functions.php';

$pdo = getConnection();

$response = [
    'success' => false,
    'message' => 'No employee ID provided'
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $employeeId = $_POST['id'] ?? null;

    if ($employeeId) {
        try {
            $sql = 'DELETE FROM employees WHERE id = :employeeId';
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':employeeId', $employeeId, PDO::PARAM_INT);
            $result = $stmt->execute();

            if ($result) {
                $response = [
                    'success' => true,

                ];
            } else {
                $response = [
                    'success' => false,

                ];
            }
        } catch (PDOException $e) {
            error_log('Delete Employee Error: ' . $e->getMessage());
            $response = [
                'success' => false,
                'message' => 'An error occurred while attempting to delete the employee'
            ];
        }
    }
}

header('Content-Type: application/json');
echo json_encode($response);
