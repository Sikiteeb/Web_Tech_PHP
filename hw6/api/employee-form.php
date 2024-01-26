<?php


if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['id'])) {

        $employeeData = getEmployeeById($_GET['id']);
        header('Content-Type: application/json');
        echo json_encode($employeeData);
        exit;
    }

    echo json_encode(['id' => '', 'firstName' => '', 'lastName' => '', 'position' => '', 'profile_picture' => 'missing.png']);
    exit;
}

