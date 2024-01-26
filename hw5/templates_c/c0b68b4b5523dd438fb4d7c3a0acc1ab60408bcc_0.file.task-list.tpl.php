<?php
/* Smarty version 4.3.4, created on 2023-11-21 07:49:15
  from '/Users/sigridhanni/PhpstormProjects/icd0007/hw5/templates/task-list.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.4',
  'unifunc' => 'content_655c60fb512327_42044909',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'c0b68b4b5523dd438fb4d7c3a0acc1ab60408bcc' => 
    array (
      0 => '/Users/sigridhanni/PhpstormProjects/icd0007/hw5/templates/task-list.tpl',
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
function content_655c60fb512327_42044909 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_checkPlugins(array(0=>array('file'=>'/Users/sigridhanni/PhpstormProjects/icd0007/vendor/smarty/smarty/libs/plugins/modifier.capitalize.php','function'=>'smarty_modifier_capitalize',),));
$_smarty_tpl->_subTemplateRender("file:header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
<body id="task-list-page">
<div id="root">
    <?php $_smarty_tpl->_subTemplateRender("file:navigation.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
    <main>
        <?php if ((isset($_smarty_tpl->tpl_vars['message']->value)) && $_smarty_tpl->tpl_vars['message']->value != '') {?>
            <div id="message-block"><?php echo $_smarty_tpl->tpl_vars['message']->value;?>
</div>
        <?php }?>
        <div class="content-card">
            <div class="content-card-header">Tasks</div>
            <div class="content-card-content">
                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['tasks']->value, 'task');
$_smarty_tpl->tpl_vars['task']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['task']->value) {
$_smarty_tpl->tpl_vars['task']->do_else = false;
?>
                    <div class="task <?php echo $_smarty_tpl->tpl_vars['task']->value['status'];?>
">
                        <span class="link"><a id="task-edit-link-<?php echo $_smarty_tpl->tpl_vars['task']->value['id'];?>
" href="<?php echo $_smarty_tpl->tpl_vars['task']->value['editLink'];?>
">Edit</a></span>

                        <div class="title" data-task-id="<?php echo $_smarty_tpl->tpl_vars['task']->value['id'];?>
">
                            <?php echo $_smarty_tpl->tpl_vars['task']->value['description'];?>

                        </div>
                        <br>
                        <div id="task-state-<?php echo $_smarty_tpl->tpl_vars['task']->value['id'];?>
" class="status <?php echo strtolower($_smarty_tpl->tpl_vars['task']->value['status']);?>
">
                            <?php echo smarty_modifier_capitalize($_smarty_tpl->tpl_vars['task']->value['status']);?>

                        </div>
                        <div class="estimate">
                            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['task']->value['estimate'], 'dot');
$_smarty_tpl->tpl_vars['dot']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['dot']->value) {
$_smarty_tpl->tpl_vars['dot']->do_else = false;
?>
                                <div class="dot <?php echo $_smarty_tpl->tpl_vars['dot']->value;?>
"></div>
                            <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                        </div>
                    </div>
                <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
            </div>
        </div>
    </main>
    <?php $_smarty_tpl->_subTemplateRender("file:footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
</div>
</body>
</html>
<?php }
}
