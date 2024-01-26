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
        <?php
        session_start();
        include 'functions.php';
        require 'save-task.php';

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
        <div class="content-card">
            <div class="content-card-header">
                Tasks
            </div>
            <div class="content-card-content">
                <div class="task">
                    <span class="link"><a href="">Edit</a></span>
                    <div class="title">
                        <div>
                            Prevent clearing CSS added to node after filterByAll() in datatable filter
                        </div>
                    </div><br>
                    <div class="status open">
                        Open
                    </div>
                    <div class="dot filled"></div>
                    <div class="dot filled"></div>
                    <div class="dot filled"></div>
                    <div class="dot filled"></div>
                    <div class="dot"></div>
                </div>
                <div class="task">
                    <span class="link"><a href="">Edit</a></span>
                    <div class="title">
                        <div>
                            Not able to exit profile editing dialogue
                        </div>
                    </div><br>
                    <div class="status pending">
                        Pending
                    </div>
                    <div class="dot filled"></div>
                    <div class="dot filled"></div>
                    <div class="dot"></div>
                    <div class="dot"></div>
                    <div class="dot"></div>
                </div>
                <div class="task">
                    <span class="link"><a href="">Edit</a></span>
                    <div class="title">
                        <div>
                            Menu thumbnails disappear when I click on profile page.
                        </div>

                    </div><br>
                    <div class="status closed">
                        Closed
                    </div>
                    <div class="dot filled"></div>
                    <div class="dot filled"></div>
                    <div class="dot filled"></div>
                    <div class="dot"></div>
                    <div class="dot"></div>
                </div><?php
                require_once 'functions.php';
                if (session_status() == PHP_SESSION_NONE) {
                    session_start();
                }
                error_reporting(E_ERROR | E_PARSE);
                $tasks = file('tasks.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

                if ($tasks !== false) {
                    foreach ($tasks as $task) {
                        $taskData = @unserialize($task);
                        if (isset($taskData['id']) && isset($taskData['description']) && isset($taskData['estimate']) && isset($taskData['status'])) {
                            displayTask($taskData['id'], $taskData['description'], $taskData['estimate'], $taskData['status']);
                        }
                    }
                } else {
                    echo "No tasks found!";
                }
                ?>
            </div>
        </div>
        <footer>
            icd0007 Sample Application
        </footer>
    </main>
</div>
</body>
</html>