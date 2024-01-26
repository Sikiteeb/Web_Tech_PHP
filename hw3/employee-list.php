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

            <div class="employee-item">
                <img src="static/img/pic1.png" alt="profile picture"/>
                <span class="name" data-employee-id="1">Daisy Smith</span>
                <span class="link"><a id="employee-edit-link-1" href="?cmd=employee-edit&id=1">Edit</a></span>
                <br><span class="position">Manager</span>

            </div><div class="employee-item">
                <img src="static/img/pic2.png" alt="profile picture"/>
                <span class="name" data-employee-id="2">James Adams</span>
                <span class="link"><a id="employee-edit-link-2" href="?cmd=employee-edit&id=2">Edit</a></span>
                <br><span class="position">Designer</span>

           </div><div class="employee-item">
               <img src="static/img/pic3.png" alt="profile picture"/>
               <span class="name" data-employee-id="3">Mary Brown</span>
               <span class="link"><a id="employee-edit-link-3" href="?cmd=employee-edit&id=3">Edit</a></span>
               <br><span class="position">Developer</span>
        </div>
            </div>  <?php

            $employees = file("employees.txt", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

            if($employees === false) {
                echo '<div id="error-block">Error reading employee data.</div>';
            } elseif(count($employees) == 0) {
                echo '<div id="notice-block">Add employees!</div>';
            } else {

                foreach($employees as $employee) {
                    $employeeData = explode(",", $employee);
                    if(count($employeeData) >= 5) {
                        list($id, $firstName, $lastName, $position, $picture) = $employeeData;
                        displayEmployee($id, $firstName, $lastName, $position, $picture);
                    }
                    elseif (count($employeeData) == 4) {
                        list($id, $firstName, $lastName, $position) = $employeeData;
                        displayEmployee($id, $firstName, $lastName, $position);
                    }
                }

            }
            ?>

        </div>

    </div>
    </main>
    <footer>
        icd0007 Sample Application
    </footer>

</div>

</body>
</html>