<?php
$cmd = $_GET['cmd'] ?? 'default';
$id = $_GET['id'] ?? null;

switch($cmd) {
    case 'employee-list':
        include 'employee-list.php';
        break;
    case 'employee-form':
        include 'employee-form.php';
        break;
    case 'employee-save':
        include 'save-employee.php';
        break;
    case 'task-list':
        include 'task-list.php';
        break;
    case 'task-form';
        include 'task-form.php';
        break;
    default:
        include '../index.php';
}