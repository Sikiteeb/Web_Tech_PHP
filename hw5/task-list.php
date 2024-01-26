<?php
error_reporting(E_ALL & ~E_DEPRECATED & ~E_USER_DEPRECATED);
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require '../vendor/autoload.php';
include_once 'functions.php';

$smarty = new Smarty();


$smarty->setTemplateDir('templates/');


$tasks = getAllTasks();
$tasksDisplayData = [];

foreach ($tasks as $task) {
    $tasksDisplayData[] = getTaskDisplayData(
        $task['id'],
        $task['description'],
        $task['status'],
        $task['estimate'],
        $task['isCompleted']
    );
}

$smarty->clearAllCache();
$smarty->clearCompiledTemplate();

$smarty->assign('tasks', $tasksDisplayData);

$smarty->display('task-list.tpl');