
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Employee List</title>
    <link rel="stylesheet" href="static/main.css">
    <link rel="stylesheet" href="static/list.css">
    <link rel="stylesheet" href="static/form.css">
</head>

<body id="employee-list-page">
<div id="root">
    <nav>
        <a href="navigation.php?cmd=dashboard" id="dashboard-link">Dashboard</a> |
        <a href="navigation.php?cmd=employee-list" id="employee-list-link">Employees</a> |
        <a href="navigation.php?cmd=employee-form" id="employee-form-link">Add Employee</a> |
        <a href="navigation.php?cmd=task-list" id="task-list-link">Tasks</a> |
        <a href="navigation.php?cmd=task-form" id="task-form-link">Add Task</a>
    </nav>
    <main>

         <?php
         if (session_status() == PHP_SESSION_NONE) {
             session_start();

         }
         include 'functions.php';
         if(isset($_GET['success'])) {
             if (isset($_GET['action']) && $_GET['action'] == 'edit') {
                 echo '<div id="message-block">Edited!</div>';
             } else if (isset($_GET['action']) && $_GET['action'] == 'add'){
                 echo '<div id="message-block">Employee added!</div>';
               }
                else if (isset($_GET['action']) && $_GET['action'] == 'delete') {
                 echo '<div id="message-block">Successfully deleted!</div>';
             }
         }


         ?>
    <div><div class="content-card">
        <div class="content-card-header">Employees</div>
        <div class="content-card-content">
            <?php

            $pdo = getConnection();

            $stmt = $pdo->prepare("SELECT id, firstName,lastName, position, profile_picture FROM employees");
            $stmt->execute();

            $employees = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($employees === false || count($employees) == 0) {
               echo '<div id="notice-block">No employees to display. Add employees!</div>';
            } else {
                foreach ($employees as $employee) {
                    displayEmployee($employee['id'], $employee['firstName'], $employee['lastName'], $employee['position'], "/static/img/" . $employee['profile_picture']);
                }
            }
            ?>
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