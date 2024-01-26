<?php
error_reporting(E_ALL & ~E_DEPRECATED & ~E_USER_DEPRECATED);

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once '../../vendor/autoload.php';
include_once '../src/functions.php';

$employees = getAllEmployees();

header('Content-Type: application/json');

echo json_encode($employees);
exit;