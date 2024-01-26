<?php

include_once 'functions.php';
require '../vendor/autoload.php';

if (session_status() == PHP_SESSION_NONE) {
session_start();
}

$smarty = new Smarty();
$smarty->setTemplateDir('templates/');

$formData = [
'description' => '',
'estimates' => 1,
'employeeId' => null,
'isCompleted' => false,
'id' => null
];

$estimates = [1, 2, 3, 4, 5];
$employees = getAllEmployees();

$isEditAction = !empty($_GET['id']);
if ($isEditAction) {
$task = getTaskById($_GET['id']);
if ($task) {
$formData = array_merge($formData, $task);
$formData['isCompleted'] = ($task['status'] === 'closed');
} else {
$_SESSION['error'] = "Task not found.";
header('Location: task-list.php');
exit();
}
}

if (isset($_SESSION['formData'])) {
$formData = array_merge($formData, $_SESSION['formData']);
unset($_SESSION['formData']);
}

$error = $_SESSION['error'] ?? null;
unset($_SESSION['error']);


$smarty->assign([
'formData' => $formData,
'estimates' => $estimates,
'employees' => $employees,
'isEditAction' => $isEditAction,
'error' => $error,
'task' => $task ?? null

]);
$smarty->debugging = false;

$smarty->display('task-form.tpl');
