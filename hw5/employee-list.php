<?php
error_reporting(E_ALL & ~E_DEPRECATED & ~E_USER_DEPRECATED);
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require '../vendor/autoload.php';
include_once 'functions.php';

$smarty = new Smarty();


$smarty->setTemplateDir('templates/');

$employees = getAllEmployees();

$employeeDisplayData = [];

foreach ($employees as $employee) {
    $imagePath = "/static/img/" . $employee['profile_picture'];
    if (!file_exists($_SERVER['DOCUMENT_ROOT'] . $imagePath)) {
        $imagePath = "/static/missing.png";
    }
    $employeeDisplayData[] = getEmployeeDisplayData(
        $employee['id'],
        $employee['firstName'],
        $employee['lastName'],
        $employee['position'],
        $employee['profile_picture']
    );
}

$smarty->clearAllCache();
$smarty->clearCompiledTemplate();

$smarty->assign('employees', $employeeDisplayData);

$smarty->display('employee-list.tpl');