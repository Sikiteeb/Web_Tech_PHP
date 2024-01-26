<?php
error_reporting(E_ALL & ~E_DEPRECATED & ~E_USER_DEPRECATED);
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require '../vendor/autoload.php';
include_once 'functions.php';

$smarty = new Smarty();


$smarty->setTemplateDir('templates/');

$employees = getEmployeesWithTaskCount();
$tasks = getAllTasks();

$smarty->clearAllCache();
$smarty->clearCompiledTemplate();

$smarty->assign('employees', $employees);
$smarty->assign('tasks', $tasks);



$smarty->display('dashboard.tpl');
