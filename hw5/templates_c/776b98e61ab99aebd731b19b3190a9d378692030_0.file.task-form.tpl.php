<?php
/* Smarty version 4.3.4, created on 2023-11-21 07:49:16
  from '/Users/sigridhanni/PhpstormProjects/icd0007/hw5/templates/task-form.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.4',
  'unifunc' => 'content_655c60fc3f7419_77168496',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '776b98e61ab99aebd731b19b3190a9d378692030' => 
    array (
      0 => '/Users/sigridhanni/PhpstormProjects/icd0007/hw5/templates/task-form.tpl',
      1 => 1699650340,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:header.tpl' => 1,
    'file:navigation.tpl' => 1,
    'file:footer.tpl' => 1,
  ),
),false)) {
function content_655c60fc3f7419_77168496 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender("file:header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
<body id="task-form-page">
<div id="root">
    <?php $_smarty_tpl->_subTemplateRender("file:navigation.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
    <main>
        <?php if ((isset($_smarty_tpl->tpl_vars['message']->value)) && $_smarty_tpl->tpl_vars['message']->value != '') {?>

        <?php if ($_smarty_tpl->tpl_vars['error']->value) {?>
            <div id="error-block"><?php echo $_smarty_tpl->tpl_vars['error']->value;?>
</div>
        <?php }?>

        <?php if ($_smarty_tpl->tpl_vars['add']->value) {?>
            <div id="message-block"><?php echo $_smarty_tpl->tpl_vars['add']->value;?>
</div>
        <?php }?>

        <?php if ($_smarty_tpl->tpl_vars['edit']->value) {?>
            <div id="message-block"><?php echo $_smarty_tpl->tpl_vars['edit']->value;?>
</div>
        <?php }?>
        <?php }?>
        <div class="content-card">
            <div class="content-card-header">Add Task</div>
            <div class="content-card-content">
                <form id="input-form" method="post" action="../save-task.php" enctype="multipart/form-data">

                    <input type="hidden" value="<?php echo (($tmp = $_smarty_tpl->tpl_vars['task']->value['id'] ?? null)===null||$tmp==='' ? '' ?? null : $tmp);?>
" name="id">
                    <div class="label-cell"><label for="desc">Description:</label></div>
                    <div class="input-cell">
                        <textarea id="desc" name="description"><?php echo htmlspecialchars((string)(($tmp = (($tmp = $_smarty_tpl->tpl_vars['formData']->value['description'] ?? null)===null||$tmp==='' ? $_smarty_tpl->tpl_vars['task']->value['description'] ?? null : $tmp) ?? null)===null||$tmp==='' ? '' ?? null : $tmp), ENT_QUOTES, 'UTF-8', true);?>
</textarea>
                    </div>

                    <div class="label-cell">Estimate:</div>
                    <div class="input-cell">
                        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['estimates']->value, 'estimate');
$_smarty_tpl->tpl_vars['estimate']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['estimate']->value) {
$_smarty_tpl->tpl_vars['estimate']->do_else = false;
?>
                            <?php $_smarty_tpl->_assignInScope('checked', '');?>
                            <?php if ((isset($_smarty_tpl->tpl_vars['task']->value)) && $_smarty_tpl->tpl_vars['task']->value['estimate'] == $_smarty_tpl->tpl_vars['estimate']->value) {?>
                                <?php $_smarty_tpl->_assignInScope('checked', "checked='checked'");?>
                            <?php } elseif ($_smarty_tpl->tpl_vars['estimate']->value == 1) {?>
                                <?php $_smarty_tpl->_assignInScope('checked', "checked='checked'");?>
                            <?php }?>
                            <label><input type='radio' name='estimate' value='<?php echo $_smarty_tpl->tpl_vars['estimate']->value;?>
' <?php echo $_smarty_tpl->tpl_vars['checked']->value;?>
/><?php echo $_smarty_tpl->tpl_vars['estimate']->value;?>
</label>
                        <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                    </div>


                    <div class="label-cell">Assigned to:</div>
                    <div class="input-cell">
                        <select id="employee" name="employeeId">
                            <option value=""></option>
                            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['employees']->value, 'employee');
$_smarty_tpl->tpl_vars['employee']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['employee']->value) {
$_smarty_tpl->tpl_vars['employee']->do_else = false;
?>
                                <?php $_smarty_tpl->_assignInScope('selected', '');?>
                                <?php if ($_smarty_tpl->tpl_vars['task']->value['employeeId'] == $_smarty_tpl->tpl_vars['employee']->value['id']) {?>
                                    <?php $_smarty_tpl->_assignInScope('selected', "selected");?>
                                <?php }?>
                                <option value="<?php echo $_smarty_tpl->tpl_vars['employee']->value['id'];?>
" <?php echo $_smarty_tpl->tpl_vars['selected']->value;?>
><?php echo htmlspecialchars((string)$_smarty_tpl->tpl_vars['employee']->value['firstName'], ENT_QUOTES, 'UTF-8', true);?>
 <?php echo htmlspecialchars((string)$_smarty_tpl->tpl_vars['employee']->value['lastName'], ENT_QUOTES, 'UTF-8', true);?>
</option>
                            <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                        </select>
                    </div>

                    <?php if ($_smarty_tpl->tpl_vars['isEditAction']->value) {?>
                        <div class="label-cell"><label for="isCompleted">Completed:</label></div>
                        <div class="input-cell">
                            <input id="isCompleted" type="checkbox" name="isCompleted" <?php if ($_smarty_tpl->tpl_vars['formData']->value['isCompleted'] || $_smarty_tpl->tpl_vars['task']->value['isCompleted']) {?>checked<?php }?>/>
                        </div>
                    <?php }?>

                    <div class="input-cell button-cell">
                        <br>
                        <?php if ($_smarty_tpl->tpl_vars['isEditAction']->value) {?>
                            <input name="deleteButton" class="button danger" type="submit" value="Delete">
                        <?php }?>
                        <br>
                        <br>
                        <button type="submit" class="main" name="submitButton">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </main>
    <?php $_smarty_tpl->_subTemplateRender("file:footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
</div>
</body><?php }
}
