<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require '../vendor/autoload.php';
include_once 'functions.php';

$smarty = new Smarty();
$smarty->setTemplateDir('templates/');


$defaultFormData = [
    'id' => '',
    'firstName' => '',
    'lastName' => '',
    'position' => '',
    'photoPath' => ''
];

$smarty->clearCompiledTemplate();
$smarty->clearAllCache();

$isEditAction = isset($_GET['id']) && $_GET['id'] !== '';
$smarty->assign('isEditAction', $isEditAction);

if ($isEditAction) {
    $employeeId = $_GET['id'];
    $employeeData = getEmployeeById($employeeId);
    $smarty->assign('employeeId', $employeeId);
    if ($employeeData) {
        $employeeDisplayData = getEmployeeDisplayData(
            $employeeData['id'],
            $employeeData['firstName'],
            $employeeData['lastName'],
            $employeeData['position'],
            $employeeData['profile_picture'] ?? '../static/img/missing.png'
        );
        $smarty->assign('formData', $employeeDisplayData);
    } else {
        $_SESSION['error'] = 'Employee not found.';
        header('Location: employee-list.php');
        exit;
    }
} else {
    $smarty->assign('formData', $defaultFormData);
}

$positions = ['Manager', 'Developer', 'Designer', 'Office Pet'];
$smarty->assign('positions', $positions);

if (isset($_SESSION['error'])) {
    $smarty->assign('error', $_SESSION['error']);
    unset($_SESSION['error']);
} else {
    $smarty->assign('error', null);
}

$smarty->display('employee-form.tpl');
