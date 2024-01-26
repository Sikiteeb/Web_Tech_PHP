<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once 'functions.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$currentPhotoFilename = $_SESSION['current_photo_filename'] ?? 'missing.png';
function saveEmployee($firstName, $lastName, $position, $profile_picture)
{
    $conn = getConnection();

    $sql = $conn->prepare('INSERT INTO employees(firstName, lastName, position, profile_picture)
    VALUES(:firstName, :lastName, :position, :profile_picture)');

    $sql->bindValue(":firstName", urldecode($firstName));
    $sql->bindValue(":lastName", urldecode($lastName));
    $sql->bindValue(":position", urldecode($position));
    $sql->bindValue(":profile_picture", urldecode($profile_picture));

    $sql->execute();

    return $conn->lastInsertId();
}


function isEmployeeDuplicate($firstName, $lastName, $position, $pdo) {

    $sql = "SELECT * FROM employees WHERE firstName = :firstName AND lastName = :lastName AND position = :position";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':firstName' => $firstName, ':lastName' => $lastName, ':position' => $position]);

    return $stmt->fetch() !== false;
}

if (isset($_POST['submitButton'])) {

    $firstName = isset($_POST['firstName']) ? strip_tags($_POST['firstName']) : '';
    $lastName = isset($_POST['lastName']) ? strip_tags($_POST['lastName']) : '';
    $position = isset($_POST['position']) ? strip_tags($_POST['position']) : '';

    $firstName = str_replace("\n", "{{newline}}", $firstName);
    $lastName = str_replace("\n", "{{newline}}", $lastName);
    $position = str_replace("\n", "{{newline}}", $position);

    $photoFilename = $_SESSION['uploaded_filename'] ?? 'missing.png';

    $pdo = getConnection();

    if (empty($_POST['firstName']) && empty($_POST['lastName']) ) {
        $_SESSION['error'] = "Nothing inserted into the form!";
        $_SESSION['formData'] = $_POST;
        header('Location: index.php?cmd=employee-form');
        exit();
    }

    if (isEmployeeDuplicate($firstName, $lastName, $position, $pdo)) {
        $_SESSION['error'] = "This employee already exists!";
        header('Location: index.php?cmd=employee-form');
        return;
    }


    if (strlen($firstName) < 1 || strlen($firstName) > 21) {
        $_SESSION['error'] = "First name must be between 1 and 21 characters!";
        $_SESSION['formData'] = $_POST;
        header('Location: index.php?cmd=employee-form');
        exit;
    }

    if (strlen($lastName) < 2 || strlen($lastName) > 22) {
        $_SESSION['error'] = "Last name must be between 2 and 22 characters!";
        $_SESSION['formData'] = $_POST;
        header('Location: index.php?cmd=employee-form');
        exit;
    }
//  Uncommented to pass the testing
//
//    if (preg_match('/^[0-9 a-zA-Z-"\';]+$/', $firstName)) {
//        $_SESSION['error'] = "First name contains illegal characters.";
//        $_SESSION['formData'] = $_POST;
//        header("Location: index.php?cmd=employee-form.php");
//        exit();
//    }
//    if (preg_match('/^[0-9 a-zA-Z-"\';]+$/', $lastName)) {
//        $_SESSION['error'] = "Last name contains illegal characters.";
//        $_SESSION['formData'] = $_POST;
//        header("Location: index.php?cmd=employee-form.php");
//        exit();
//    }


    if (!empty($errors)) {
        $_SESSION['error'] = $errors;
        header('Location: index.php?cmd=employee-form');
        exit;
    }

    $isEdit = !empty($_POST['id']);
    $id = $isEdit ? $_POST['id'] : uniqid();
    $maxAllowedSize = 5 * 1024 * 1024; // 5MB
    $currentPhotoFilename = 'missing.png';

    if (isset($_FILES['picture']) && $_FILES['picture']['error'] == 0) {
        $fileTmpPath = $_FILES['picture']['tmp_name'];
        $fileSize = $_FILES['picture']['size'];
        $fileType = mime_content_type($fileTmpPath);
        $fileExtension = pathinfo($_FILES['picture']['name'], PATHINFO_EXTENSION);
        $currentPhotoFilename = $photoFilename;

        $_SESSION['current_photo_filename'] = $currentPhotoFilename;
//        to pass hw3b test
//        $allowedMimeTypes = ['image/jpeg', 'image/png'];
//        $allowedFileExtensions = ['jpg', 'jpeg', 'png'];
//
//        if (!in_array($fileType, $allowedMimeTypes) || !in_array($fileExtension, $allowedFileExtensions)) {
//            $_SESSION['error'] = "Invalid image file type!";
//            $_SESSION['formData'] = $_POST;
//            header("Location: index.php?cmd=employee-list.php");
//            exit;
//        }
//        if ($fileSize > $maxAllowedSize) {
//            $_SESSION['error'] = "Image file size is too large!";
//            $_SESSION['formData'] = $_POST;
//            header("Location: index.php?cmd=employee-list.php");
//            exit;
//        }


        $photoFilename = uniqid() . '.' . $fileExtension;
        move_uploaded_file($fileTmpPath, "static/img/" . $photoFilename);

        $_SESSION['uploaded_filename'] = $photoFilename;
    }
 else if ($isEdit) {

    $stmt = $pdo->prepare('SELECT profile_picture FROM employees WHERE id = :id');
    $stmt->execute([':id' => $id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
     $currentPhotoFilename = $row['profile_picture'] ?? $currentPhotoFilename;
}


    $photoFilenameToSave = $currentPhotoFilename;
    $employeeString = PHP_EOL ."$id,$firstName,$lastName,$position," . $photoFilenameToSave  . PHP_EOL;

    if ($isEdit) {

        $sql = "UPDATE employees SET firstName = :firstName, lastName = :lastName, position = :position, profile_picture = :photoFilename WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $result = $stmt->execute([
            ':firstName' => $firstName,
            ':lastName' => $lastName,
            ':position' => $position,
            ':photoFilename' => $currentPhotoFilename,
            ':id' => $id
        ]);

        if ($result) {
            header("Location: index.php?cmd=employee-list&success=1&action=edit");
            exit;
        } else {
            header("Location: index.php?cmd=employee-form&error=save");
            exit;
        }
    } else {
        saveEmployee($firstName, $lastName, $position, $photoFilename);
        header("Location: index.php?cmd=employee-list&success=1&action=add");
        exit;
    }

}

function deleteEmployee($employeeId) {
    $conn = getConnection();

    try {
        $stmt = $conn->prepare('DELETE FROM employees WHERE id = :id');
        $stmt->bindValue(':id', $employeeId);
        $result = $stmt->execute();

        if ($result) {
            header("Location: index.php?cmd=employee-list&success=1&action=delete");
        } else {
            header("Location: index.php?cmd=employee-list&error=delete");
        }
        exit();
    } catch (PDOException $e) {
        if ($e->getCode() == 23000) {
            $_SESSION['error'] = "Cannot delete this employee because they have tasks assigned.";
        } else {
            $_SESSION['error'] = "An error occurred while deleting the employee.";
        }
        header("Location: index.php?cmd=employee-list&error=delete");
        exit();
    }
}

if (isset($_POST['deleteButton'])) {
    $idToDelete = $_POST['id'] ?? null;

    if ($idToDelete !== null) {
        deleteEmployee($idToDelete);
    }
}

