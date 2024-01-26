<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="hw5_0/static/main.css">
    <link rel="stylesheet" href="hw5_0/static/list.css">
    <link rel="stylesheet" href="hw5_0/static/form.css">
</head>
<body id="dashboard-page">
<div id="root">
    <nav>
        <a href="hw5_0/navigation.php?cmd=dashboard" id="dashboard-link">Dashboard</a> |
        <a href="hw5_0/navigation.php?cmd=employee-list" id="employee-list-link">Employees</a> |
        <a href="hw5_0/navigation.php?cmd=employee-form" id="employee-form-link">Add Employee</a> |
        <a href="hw5_0/navigation.php?cmd=task-list" id="task-list-link">Tasks</a> |
        <a href="hw5_0/navigation.php?cmd=task-form" id="task-form-link">Add Task</a>
    </nav>
    <main>
        <div><div id="dash-layout">
                <div class="content-card">
                    <div class="content-card-header">Employees</div>
                    <div class="content-card-content">
                        <?php
                        include_once 'hw5_0/functions.php';

                        $employees = getEmployeesWithTaskCount();
                        foreach ($employees as $employee) {
                            echo '<div class="employee-item">';
                            echo '<img src="hw5_0/static/img/' . htmlspecialchars($employee['profile_picture']) . '" alt="Profile picture of ' . htmlspecialchars($employee['name']) . '"/>';
                            echo '<span class="name">' . htmlspecialchars($employee['name']) . '</span>';
                            echo '<span id="employee-task-count-' . $employee['id'] . '" class="count">' . $employee['task_count'] . '</span>';
                            echo '<br><span class="position">' . htmlspecialchars($employee['position']) . '</span>';
                            echo '</div>';
                        }
                        ?>

                    </div>
                </div>
                <div class="content-card">
                    <div class="content-card-header">Tasks</div>
                    <div class="content-card-content">
                        <?php
                        $tasks = getAllTasks();
                        foreach ($tasks as $task) {
                            displayTask($task['id'], htmlspecialchars($task['description']), $task['status'], $task['estimate'], $task['isCompleted']);
                        }
                        ?>
                    </div>
                </div>

            </div></div>
    </main>
    <footer>
        icd0007 Sample Application
    </footer>

</div>


</body>
</html>
