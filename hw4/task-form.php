<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>icd0007 Sample Application</title>
    <link rel="stylesheet" href="static/main.css">
    <link rel="stylesheet" href="static/list.css">
    <link rel="stylesheet" href="static/form.css">
</head>
<body id="task-form-page">
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
        include_once 'functions.php';
        include_once 'save-task.php';
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
            unset($_SESSION['add']);
        }
        if (isset($_SESSION['edit'])) {
            echo '<div id="message-block">' . $_SESSION['edit'] . '</div>';
            unset($_SESSION['edit']);
        }

        $task = isset($_GET['id']) ? getTaskById($_GET['id']) : [
            'description' => '',
            'status' => '',
            'estimate' => '',
            'employeeId' => '',
            'isCompleted' => ''
        ];


        $task = $_SESSION['form_data'] ?? $task;


        unset($_SESSION['form_data']);

        ?>
            <div class="content-card">
                <div class="content-card-header">Add Task</div>
                <div class="content-card-content">
                        <form id="input-form" method="post" action="save-task.php" enctype="multipart/form-data">

                            <input type="hidden" value="<?php echo $task['id'] ?? ''; ?>" name="id">
                            <div class="label-cell"><label for="desc">Description:</label></div>
                            <div class="input-cell">
                                <textarea id="desc" name="description"><?php echo htmlspecialchars($formData['description'] ?? ($task['description'] ?? '')); ?></textarea>
                            </div>

                            <div class="label-cell">Estimate:</div>
                            <div class="input-cell">
                                <?php
                                for ($i = 1; $i <= 5; $i++) {
                                    $checked = '';

                                    if (isset($formData['estimate']) && $formData['estimate'] == $i) {
                                        $checked = 'checked';
                                    } elseif (isset($task['estimate']) && $task['estimate'] == $i) {
                                        $checked = 'checked';
                                    }

                                    echo "<label><input type='radio' name='estimate' value='$i' $checked/>$i</label>";
                                }
                                ?>
                            </div>
                            <div class="label-cell">Assigned to:</div>
                            <div class="input-cell">
                                <label for="employee"></label><select id="employee" name="employeeId">
                                    <option value=""></option>
                                    <?php
                                    ini_set('display_errors', 1);
                                    error_reporting(E_ALL);

                                    $employees = getAllEmployees();

                                    foreach ($employees as $employee) {
                                        $selected = isset($task['employeeId']) && $task['employeeId'] == $employee['id'] ? 'selected' : '';
                                        echo "<option value='" . $employee['id'] . "' $selected>" . htmlspecialchars($employee['firstName'] . " " . $employee['lastName']) . "</option>";

                                    }
                                    ?>
                                </select>
                            </div>
                            <?php
                                   $isEditAction = isset($_GET['id']);
                                   if ($isEditAction) {
                                     $isChecked = (isset($formData['isCompleted']) && $formData['isCompleted']) ? 'checked' : '';
                                     if(empty($isChecked) && isset($task['isCompleted']) && $task['isCompleted']){
                                       $isChecked = 'checked';
                                     }
                                    echo '<div class="label-cell"><label for="isCompleted">Completed:</label></div>';
                                    echo '<div class="input-cell"><input id="isCompleted" type="checkbox" name="isCompleted" '.$isChecked.'/></div>';
                                     }
                                ?>
                            <div class="input-cell button-cell">
                                <br>
                                <?php


                                if ($isEditAction) {
                                    echo '<input name="deleteButton" class="button danger" type="submit" value="Delete">';
                                }
                                ?>

                                <br>
                                <br>
                                <button type="submit" class="main" name="submitButton">Save</button>
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