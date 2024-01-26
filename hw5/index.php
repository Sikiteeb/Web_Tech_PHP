<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require '../vendor/autoload.php';
include_once 'functions.php';

$smarty = new Smarty();

$smarty->setTemplateDir(__DIR__ . '../templates');
$smarty->setCompileDir(__DIR__ . '../templates_c');
$smarty->setCacheDir(__DIR__ . '../cache');
$smarty->setConfigDir(__DIR__ . '../configs');


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
    case 'dashboard';
        include 'dashboard.php';
        break;
    default:
        include 'dashboard.php';
}

