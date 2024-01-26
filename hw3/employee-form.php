<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="UTF-8">
    <title>icd0007 Sample Application</title>
    <link rel="stylesheet" href="static/main.css">
    <link rel="stylesheet" href="static/list.css">
    <link rel="stylesheet" href="static/form.css">
</head>
<body id="employee-form-page">
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
        include 'functions.php';
        require 'save-employee.php';

        if (session_status() == PHP_SESSION_NONE) {
            session_start();

        }

        if (isset($_SESSION['error'])) {
            echo '<div id="error-block">' . $_SESSION['error'] . '</div>';
            unset($_SESSION['error']);
        }
        $formData = $_SESSION['formData'] ?? [];
        unset($_SESSION['formData']);

        if (isset($_SESSION['add'])) {
            echo '<div id="message-block">' . $_SESSION['add'] . '</div>';
            unset($_SESSION['added']);
        }
          //  $employee = null;

        if (isset($_SESSION['edit'])) {
            echo '<div id="message-block">' . $_SESSION['edit'] . '</div>';
            unset($_SESSION['edit']);
        }
        if (isset($_GET['id'])) {
            $employee = getEmployeeDetails($_GET['id']);
        } else {
            $employee = [
                'firstName' => '',
                'lastName' => '',
                'position' => '',
                'profile_picture' => '',
            ];
        }

        ?>

        <div class="content-card">
            <div class="content-card-header">Add Employee</div>
            <div class="content-card-content">

                <form id="input-form" method="post" action="save-employee.php" enctype="multipart/form-data">

                    <input type="hidden" value="<?php echo $employee['id'] ?? ''; ?>" name="id">

                    <div class="label-cell"><label for="fn">First name:</label></div>
                    <input type="text" name="firstName" value="<?php echo htmlspecialchars($formData['firstName'] ?? ($employee['firstName'] ?? '')); ?>" id="firstName">

                    <div class="label-cell"><label for="ln">Last name:</label></div>
                    <input type="text" name="lastName" value="<?php echo htmlspecialchars($formData['lastName'] ?? ($employee['lastName'] ?? '')); ?>" id="lastName" >

                    <div class="label-cell"><label for="po">Position:</label></div>
                    <input type="text" name="position" value="<?php echo htmlspecialchars($formData['position'] ?? ($employee['position'] ?? '')); ?>" id="position">


                    <div class="label-cell"><label for="pic">Picture:</label></div>
                    <div class="input-cell">
                        <input id="pic" name="picture" type="file"/>
                        <label id="file-input-label" for="pic" class="current-photo-filename">
                            <?= (!empty($employee['profile_picture']) && $employee['profile_picture'] !== 'missing.png') ? "Current file: " . $employee['profile_picture'] : 'Select a file'; ?>
                        </label>
                    </div>



                    <div class="label-cell"></div>
                    <div class="input-cell button-cell">
                        <br>
                        <?php
                        $isEditAction = isset($_GET['id']);

                        if ($isEditAction) {
                        echo '<input name="deleteButton" class="button danger" type="submit" value="Delete">';
                        }
                        ?>
                        <button type="submit" formaction="?cmd=employee-save" class="main" name="submitButton">Save</button>
                    </div>
                </form>
            </div>
        </div>

    </main>
    <footer>
        icd0007 Sample Application
    </footer>

</div>

</body>
</html>