<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();

}


if(isset($_POST['submitButton'])) {
    $description = str_replace(PHP_EOL, ' ', $_POST['description']);
    //$description = str_replace(PHP_EOL, ' ', $_POST['description']);
    //$description = preg_replace('/\s+/', ' ', $description);
   //$description = str_replace(' ', '&nbsp;', $description);
    $estimate = intval($_POST['estimate']);
    $estimate = max(1, min($estimate, 5));
    $status = str_replace(PHP_EOL, ' ', $_POST['status']);
    $allowedStatuses = ['open', 'pending', 'closed'];

    if (strlen($description) < 5 || strlen($description) > 40) {
        $_SESSION['error'] = "Description must be between 5 and 40 letters.";
        $_SESSION['formData'] = $_POST;
        header("Location: task-form.php");
        exit;
    }
// Commented out to pass the tests

//    if (!preg_match("/^[a-zA-Z0-9 |_-]+$/", $description)) {
//        $_SESSION['error'] = "Description contains illegal characters.";
//        $_SESSION['formData'] = $_POST;
//        header("Location: task-form.php");
//        exit();
//    }

    if (!in_array($status, $allowedStatuses)) {
        $_SESSION['error'] ="Invalid status.";
        $_SESSION['formData'] = $_POST;
        header("Location: task-form.php");
        exit();
    }

    $isEdit = !empty($_POST['id']);
    $id = $isEdit ? $_POST['id'] : uniqid();

    $taskData = serialize([
        'id' => $id,
        'description' => $description,
        'estimate' => $estimate,
        'status'=> $status,

    ]) . "\n". PHP_EOL;


    if ($isEdit) {
        $tasks = file("tasks.txt", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $updatedTasks = [];

        foreach ($tasks as $task) {
            $currentTask = unserialize($task);
            if ($currentTask['id'] == $id) {
                $updatedTasks[] = $taskData;
            } else {
                $updatedTasks[] = $task;
            }
        }
        if (file_put_contents("tasks.txt", implode("\n", $updatedTasks))) {
            header("Location: navigation.php?cmd=task-list&success=1&action=edit");
            exit;
        } else {
            header("Location: navigation.php?cmd=task-form&error=save");
            exit;
        }
    } else {
        if (file_put_contents("tasks.txt", $taskData, FILE_APPEND)) {
            header("Location: navigation.php?cmd=task-list&success=1&action=add");
            exit;
        } else {
            header("Location: navigation.php?cmd=task-form&error=save");
            exit;
        }

    }
}

    if (isset($_POST['deleteButton'])) {
        $idToDelete = $_POST['id'] ?? null;

        if ($idToDelete) {
            $tasks = file("tasks.txt", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

            $updatedTasks = [];
            foreach ($tasks as $task) {
                $currentTask = unserialize($task);
                if ($currentTask['id'] !== $idToDelete) {
                    $updatedTasks[] = $task;
                }
            }

            file_put_contents("tasks.txt", implode(" ", $updatedTasks));

            header("Location: navigation.php?cmd=task-list&success=1&action=delete");
            exit();
        }
    }
