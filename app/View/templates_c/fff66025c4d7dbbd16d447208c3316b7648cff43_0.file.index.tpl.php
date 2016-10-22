<?php
/* Smarty version 3.1.30, created on 2016-10-22 14:18:48
  from "/Users/adrien/Sites/mvc/app/View/templates/content/index.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_580b5928789e05_95709427',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'fff66025c4d7dbbd16d447208c3316b7648cff43' => 
    array (
      0 => '/Users/adrien/Sites/mvc/app/View/templates/content/index.tpl',
      1 => 1477138715,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_580b5928789e05_95709427 (Smarty_Internal_Template $_smarty_tpl) {
?>
<!DOCTYPE html>
<html>
<head>
    <title>Hello World!</title>
    <link rel="stylesheet" type="text/css" href="<?php echo $_smarty_tpl->tpl_vars['asset']->value->path('app.css');?>
">
</head>
<body>
    <h1>Hello World!</h1>

    <div id="app">
        
    </div>

    <?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['asset']->value->path('app.js');?>
"><?php echo '</script'; ?>
>
</body>
</html><?php }
}
