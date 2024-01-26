<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>icd0007 Sample Application</title>
    <link rel="stylesheet" href="static/main.css">
    <link rel="stylesheet" href="static/list.css">
    <link rel="stylesheet" href="static/form.css">
</head>
<body id="task-list-page">
<div id="root">
    <nav>
        <a href="navigation.php?cmd=dashboard" id="dashboard-link">Dashboard</a> |
        <a href="navigation.php?cmd=employee-list" id="employee-list-link">Employees</a> |
        <a href="navigation.php?cmd=employee-form" id="employee-form-link">Add Employee</a> |
        <a href="navigation.php?cmd=task-list" id="task-list-link">Tasks</a> |
        <a href="navigation.php?cmd=task-form" id="task-form-link">Add Task</a>
    </nav>
    <main>
    <div>
        <?php

        if (session_status() == PHP_SESSION_NONE) {
            session_start();

        }
        include 'functions.php';
        include_once 'save-task.php';

        if(isset($_GET['success'])) {
            if (isset($_GET['action']) && $_GET['action'] == 'edit') {
                echo '<div id="message-block">Edited!</div>';
            } else if (isset($_GET['action']) && $_GET['action'] == 'add'){
                echo '<div id="message-block">Task added!</div>';
            }
            else if (isset($_GET['action']) && $_GET['action'] == 'delete') {
                echo '<div id="message-block">Task deleted!</div>';
            }
        }
        ?>
        <div>
        <div class="content-card">
            <div class="content-card-header">Tasks</div>
            <div class="content-card-content">
                <?php
                $pdo = getConnection();
                error_reporting(E_ERROR | E_PARSE);

                $stmt = $pdo->prepare("SELECT id, description, status, estimate, employeeId, isCompleted FROM tasks");
                $stmt->execute();

                $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);

                foreach ($tasks as $task) {
                    displayTask($task['id'], $task['description'], $task['status'], $task['estimate'], $task['isCompleted']);
                    }

                ?>
               </div>
            </div>
        </div>
    </div>
    </main>

    <footer>
        icd0007 Sample Application
    </footer>

</div>

</body>
</html>