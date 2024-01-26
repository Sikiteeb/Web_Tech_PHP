<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require '../vendor/autoload.php';
include 'functions.php';

$smarty = new Smarty();
$smarty->setTemplateDir('templates/');

$message = '';
$error = '';
$add = '';
$edit = '';
$formData = [];

if (isset($_GET['success'])) {
    if (isset($_GET['action'])) {
        switch ($_GET['action']) {
            case 'edit':
                $message = 'Edited!';
                break;
            case 'add':
                $message = 'Employee added!';
                break;
            case 'delete':
                $message = 'Successfully deleted!';
                break;
        }
    }
    $smarty->assign('message', $message);
}
$smarty->assign('message', $message);

$error = '';
$add = '';
$edit = '';

if (isset($_SESSION['error'])) {
    $error = $_SESSION['error'];
    unset($_SESSION['error']);
}

if (isset($_SESSION['add'])) {
    $add = $_SESSION['add'];
    unset($_SESSION['add']);
}

if (isset($_SESSION['edit'])) {
    $edit = $_SESSION['edit'];
    unset($_SESSION['edit']);
}
if (isset($_SESSION['formData'])) {
    $formData = $_SESSION['formData'];
    unset($_SESSION['formData']);
}

$smarty->assign('error', $error);
$smarty->assign('add', $add);
$smarty->assign('edit', $edit);
$smarty->assign('formData', $formData);

$smarty->assign('message', $message ?? '');
