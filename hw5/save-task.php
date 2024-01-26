<?php
require_once'functions.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$pdo = getConnection();


if(isset($_POST['submitButton'])) {
    $description = str_replace(PHP_EOL, ' ', $_POST['description']);
    $estimate = intval($_POST['estimate']);
    $estimate = max(1, min($estimate, 5));
    $employeeId = intval($_POST['employeeId']);
    $isCompleted = isset($_POST['isCompleted']) && $_POST['isCompleted'] == 'on' ? 1 : 0;

    if (empty($employeeId)) {
        $employeeId = NULL;
    }

    if ($employeeId == NULL && !$isCompleted) {
        $status = 'open';
    } elseif ($employeeId && !$isCompleted) {
        $status = 'pending';
    } elseif ($isCompleted) {
        $status = 'closed';
    }

    if (strlen($description) < 5 || strlen($description) > 40) {
        $_SESSION['error'] = "Description must be between 5 and 40 letters.";
        $_SESSION['formData'] = $_POST;
        header("Location: task-form.php");
        exit;
    }

    $isEdit = !empty($_POST['id']);
    $id = $isEdit ? $_POST['id'] : uniqid();

    $taskData = serialize([
            'id' => $id,
            'description' => $description,
            'status' => $status,
            'estimate' => $estimate,
            'employeeId' => $employeeId,
            'isCompleted' => $isCompleted,

        ]) . "\n" . PHP_EOL;

    $isEdit = !empty($_POST['id']);
    $id = $isEdit ? $_POST['id'] : uniqid();

    if ($isEdit) {
        if (empty($employeeId)) {
            $employeeId = NULL;
        }

        if ($employeeId == NULL && !$isCompleted) {
            $status = 'open';
        } elseif ($employeeId && !$isCompleted) {
            $status = 'pending';
        } elseif ($isCompleted) {
            $status = 'closed';
        }

        $stmt = $pdo->prepare("UPDATE tasks SET description = ?, status = ?, estimate = ?, employeeId = ?, isCompleted = ? WHERE id = ?");


        if ($stmt->execute([$description, $status, $estimate, $employeeId, $isCompleted, $id])) {
            header("Location: index.php?cmd=task-list&success=1&action=edit");
            exit;
        } else {
            header("Location: index.php?cmd=task-form&error=save");
            exit;
        }
       }
        else{
        $stmt = $pdo->prepare("INSERT INTO tasks (description, status, estimate, employeeId, isCompleted) VALUES (?, ?, ?, ?, ?)");
        if ($stmt->execute([$description, $status, $estimate, $employeeId, $isCompleted])) {
            header("Location: index.php?cmd=task-list&success=1&action=add");
            exit;
        } else {
            header("Location: index.php?cmd=task-form&error=save");
            exit;
        }
    }

}
if (isset($_POST['deleteButton'])) {
    $idToDelete = $_POST['id'] ?? null;

    if ($idToDelete) {
        $pdo = getConnection();

        $stmt = $pdo->prepare("SELECT employeeId FROM tasks WHERE id = :id");
        $stmt->bindParam(':id', $idToDelete, PDO::PARAM_INT);
        $stmt->execute();
        $employeeId = $stmt->fetchColumn();

        if ($employeeId !== false && $employeeId > 0) {
            $stmt = $pdo->prepare("UPDATE employees SET task_count = GREATEST(0, task_count - 1) WHERE id = :employeeId");
            $stmt->bindParam(':employeeId', $employeeId, PDO::PARAM_INT);
            $stmt->execute();
        }

        $stmt = $pdo->prepare("DELETE FROM tasks WHERE id = :id");
        $stmt->bindParam(':id', $idToDelete, PDO::PARAM_INT);

        if ($stmt->execute()) {
            header("Location: index.php?cmd=task-list&success=1&action=delete");
            exit();
        } else {
            header("Location: index.php?cmd=task-list&error=1&action=delete");
            exit();
        }
    }
}


