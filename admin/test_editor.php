<?php
include 'admin_header.php';
include XOOPS_ROOT_PATH . '/class/xoopsformloader.php';
?>
<html>
<head>
</head>
<body>
<?php
$test_editor = array();
$test_editor['class']= $_GET['class'];
$test_editor['path']= $_GET['path'];
$editor = new XoopsFormDhtmlTextArea('test_textarea','test_textarea','contenuto di esempio...', 10, 60);
echo "<div>";
echo ($editor->render());
echo "</div>";
?>
</body>
</html>
