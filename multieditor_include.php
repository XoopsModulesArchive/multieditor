<?php

global $xoopsUser,$xoopsModule,$htmlEditor,$test_editor;

include_once XOOPS_ROOT_PATH."/class/xoopsmodule.php";
include_once XOOPS_ROOT_PATH."/class/xoopstree.php";
include_once XOOPS_ROOT_PATH."/class/xoopslists.php";
include_once XOOPS_ROOT_PATH."/class/xoopsformloader.php";

include_once XOOPS_ROOT_PATH."/modules/multieditor/include/functions.php";
$myts =& MyTextSanitizer::getInstance();

$user_groups = (is_object($xoopsUser)) ? $xoopsUser->getGroups() : XOOPS_GROUP_ANONYMOUS;
// isadmin is true if user has 'edit users' admin rights
$gperm_handler = & xoops_gethandler( 'groupperm' );
//$isAdmin = $gperm_handler->checkRight( 'system_admin', XOOPS_SYSTEM_USER, $user_groups);

$main_module = $xoopsModule;
$main_module_id = $main_module->getVar('mid');

// not used for now, for future functions - start
    $textarea_name = $this->getName();
    $current_page_name = curPageName();
    $current_absolute_url = curPageURL(true);
    $current_xoops_url = curPageURL(false);
// not used for now, for future functions - end

$default_editor = get_default_editor();

$user_editor = $default_editor;
$editors_list = array();

if ($xoopsUser->isAdmin()) // CHECK IF CURRENT USER IS AN ADMINISTRATOR (beta)
    {
    // get Admin group editor
    // COME OTTENGO ID del GRUPPO ADMINISTRATORI????
    $user_editor_id = get_group_module_editor($main_module_id,1); // '1' is administrator group (I think???)
    // COME OTTENGO ID del GRUPPO ADMINISTRATORI????
    $user_editor = get_editor_by_id($user_editor_id['editor_id']);
    }
else
    {
    //echo ("NOT ADMIN");//debug
    $temp_editors = array();
    foreach ($user_groups as $user_group)
        {
        $temp = get_group_module_editor($main_module_id,$user_group);
        $temp_editors[] = get_editor_by_id($temp['editor_id']);
        }
    foreach ($temp_editors as $temp_editor)
        {
        if (($temp_editor['weight'] < $compare_weight) || !isset($compare_weight))
            {
            $user_editor = $temp_editor;
            $compare_weight = $temp_editor['weight'];
            }
        }
    }

    $class = (isset($test_editor))?$test_editor['class']:$user_editor['class'];
    $path = (isset($test_editor))?$test_editor['path']:$user_editor['path'];

//    $path_array = explode("/", $path);
    $path_array = split('[\\/]', $path);
    $name = $path_array[count($path_array)-2];
    $this->htmlEditor = array($class,$path);
    //$options['editor'] = array($class,$path);
    if ($path_array && $name && $name!="")
        $options['editor'] = $name;
?>
