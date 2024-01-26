<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

function isEmployeeDuplicate($firstName, $lastName, $position) {
    $employees = file("employees.txt", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($employees as $employee) {
        list($currentFirstName, $currentLastName, $currentPosition) = explode(",", $employee);
        if ($firstName === $currentFirstName && $lastName === $currentLastName && $position === $currentPosition) {
            return true;
        }
    }
    return false;
}

if (isset($_POST['submitButton'])) {
    $firstName = isset($_POST['firstName']) ? strip_tags($_POST['firstName']) : '';
    $lastName = isset($_POST['lastName']) ? strip_tags($_POST['lastName']) : '';
    $position = isset($_POST['position']) ? strip_tags($_POST['position']) : '';

    // Normalize data
    $firstName = str_replace("\n", "{{newline}}", $firstName);
    $lastName = str_replace("\n", "{{newline}}", $lastName);
    $position = str_replace("\n", "{{newline}}", $position);

    if (isEmployeeDuplicate($firstName, $lastName, $position)) {
        $_SESSION['error'] = "This employee already exists!";
        header("Location: employee-form.php");
        exit;
    }

    if (empty($_POST['firstName']) && empty($_POST['lastName']) && empty($_POST['position'])) {
        $_SESSION['error'] = "Nothing inserted into the form!";
        $_SESSION['formData'] = $_POST;
        header('Location: navigation.php?cmd=employee-form');
        exit();
    }

    if (strlen($firstName) < 1 || strlen($firstName) > 21) {
        $_SESSION['error'] = "First name must be between 1 and 21 characters!";
        $_SESSION['formData'] = $_POST;
        header('Location: navigation.php?cmd=employee-form');
        exit;
    }

    if (strlen($lastName) < 2 || strlen($lastName) > 22) {
        $_SESSION['error'] = "Last name must be between 2 and 22 characters!";
        $_SESSION['formData'] = $_POST;
        header('Location: navigation.php?cmd=employee-form');
        exit;
    }

    if (!preg_match('/^[0-9 a-zA-Z-\']+$/', $firstName) || !preg_match('/^[0-9 a-zA-Z-\']+$/', $lastName)) {
        $_SESSION['error'] = "First name and last name cannot contain illegal characters!";
        $_SESSION['formData'] = $_POST;
        header('Location: navigation.php?cmd=employee-list');
        exit;
    }

    if (!empty($errors)) {
        $_SESSION['error-block'] = $errors;
        header('Location: navigation.php?cmd=employee-list');
        exit;
    }

    $isEdit = !empty($_POST['id']);
    $id = $isEdit ? $_POST['id'] : uniqid();
    $photoFilename = $_SESSION['uploaded_filename'] ?? 'missing.png';

    if (isset($_FILES['picture']) && $_FILES['picture']['error'] == 0) {
        $fileTmpPath = $_FILES['picture']['tmp_name'];
        $fileExtension = pathinfo($_FILES['picture']['name'], PATHINFO_EXTENSION);

        if (strtolower($fileExtension) === 'bmp') {
            $photoFilename = $id . '.png';
        } else {
            $photoFilename = $id . '.' . $fileExtension;
        }

        move_uploaded_file($fileTmpPath, $photoFilename);
        $_SESSION['uploaded_filename'] = $photoFilename;
    }


    $employeeString = PHP_EOL . "$id,$firstName,$lastName,$position,$photoFilename" . PHP_EOL;

    if ($isEdit) {
        $employees = file("employees.txt", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $updatedEmployees = [];

        foreach ($employees as $employee) {
            list($currentId) = explode(",", $employee);
            $updatedEmployees[] = ($currentId === $id) ? $employeeString : $employee;
        }

        unset($_SESSION['uploaded_filename']);
        file_put_contents("employees.txt", implode("\n", $updatedEmployees))
            ? header("Location: navigation.php?cmd=employee-list&success=1&action=edit")
            : header("Location: navigation.php?cmd=employee-form&error=save");
        exit;
    } else {
        file_put_contents("employees.txt", $employeeString, FILE_APPEND)
            ? header("Location: navigation.php?cmd=employee-list&success=1&action=add")
            : header("Location: navigation.php?cmd=employee-form&error=save");
        exit;
    }
}

if (isset($_POST['deleteButton'])) {
    $idToDelete = $_POST['id'] ?? null;
    if ($idToDelete) {
        $employees = file("employees.txt", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $updatedEmployees = array_filter($employees, function($employee) use ($idToDelete) {
            list($id) = explode(",", $employee);
            return $id !== $idToDelete;
        });

        file_put_contents("employees.txt", implode("\n", $updatedEmployees));
        header("Location: navigation.php?cmd=employee-list&success=1&action=delete");
        exit;
    }
}
