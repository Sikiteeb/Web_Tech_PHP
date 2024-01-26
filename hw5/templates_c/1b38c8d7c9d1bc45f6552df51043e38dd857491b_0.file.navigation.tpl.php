<?php
/* Smarty version 4.3.4, created on 2023-11-21 07:49:15
  from '/Users/sigridhanni/PhpstormProjects/icd0007/hw5/templates/navigation.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.4',
  'unifunc' => 'content_655c60fb516f38_70373291',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '1b38c8d7c9d1bc45f6552df51043e38dd857491b' => 
    array (
      0 => '/Users/sigridhanni/PhpstormProjects/icd0007/hw5/templates/navigation.tpl',
      1 => 1699650340,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_655c60fb516f38_70373291 (Smarty_Internal_Template $_smarty_tpl) {
?><nav>
    <a href="?cmd=dashboard" id="dashboard-link">Dashboard</a> |
    <a href="?cmd=employee-list" id="employee-list-link">Employees</a> |
    <a href="?cmd=employee-form" id="employee-form-link">Add Employee</a> |
    <a href="?cmd=task-list" id="task-list-link">Tasks</a> |
    <a href="?cmd=task-form" id="task-form-link">Add Task</a>
</nav><?php }
}
