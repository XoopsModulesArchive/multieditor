<?php
/*
* Get/set editors list
*/
include 'admin_header.php';

$op = 'list';

if (isset($_POST['op']))
    $op = trim($_POST['op']);
elseif (isset($_GET['op']))
    $op = trim($_GET['op']);



if ($op=='list')
    {
    $module_id = $xoopsModule->getVar('mid');
    xoops_cp_header();
    adminMenu(1, _ME_MULTIED_ED_LIST);
    echo "<form name='editors_form' method='post' action='editors.php'>\n";
    echo "<table class='outer' width='100%' cellspacing='1' cellpadding='3' border='0'>\n";
    echo "<tbody>\n";
    echo "<tr class='odd'>\n";
    echo "<th>"._ME_EDITOR_ID."</th>\n";
    echo "<th>"._ME_EDITOR_NAME."</th>\n";
    echo "<th>"._ME_EDITOR_CLASS."</th>\n";
    echo "<th>"._ME_EDITOR_PATH."</th>\n";
    echo "<th>"._ME_EDITOR_WEIGHT."</th>\n";
    echo "<th>"._ME_EDITOR_DEFAULT."</th>\n";
    echo "<th>"._ME_EDITOR_OPERATIONS."</th>\n";
    echo "</tr>\n";
    
    $sql = "SELECT *";
    $sql.= " FROM ". $xoopsDB->prefix('multieditor_editors');
    $sql.= " ORDER BY multied_weight ASC";
    $query = $xoopsDB->query($sql);
    if(!$query) exit($xoopsDB->error());
    while($myrow = $xoopsDB->fetchArray($query))
        {
        $id = intval($myrow['multied_id']);
        $name = htmlspecialchars($myrow['multied_name'],ENT_QUOTES);
        $class = htmlspecialchars($myrow['multied_class'],ENT_QUOTES);
        $path = htmlspecialchars($myrow['multied_path'],ENT_QUOTES);
        $weight = intval($myrow['multied_weight']);
        $default = $myrow['multied_default'];
        echo "<tr class='odd'>\n";
        echo "<td>".$id."</td>\n";
        echo "<td><input type='text' id='_name[".$id."]' name='_name[".$id."]' value='".$name."' size='18' /></td>\n";
        echo "<td><input type='text' id='_class[".$id."]' name='_class[".$id."]' value='".$class."' size='24' /></td>\n";
        echo "<td><input type='text' id='_path[".$id."]' name='_path[".$id."]' value='".$path."' size='50' /></td>\n";
        echo "<td><input type='text' id='_weight[".$id."]' name='_weight[".$id."]' value='".$weight."' size='2' /></td>\n";
        echo "<td><input type='radio' id='default' name='default' value='".$id."'".(($default)?" checked='checked'":"")." /></td>\n";
        echo "<td>\n";
        echo "<a href='editors.php?op=delete&editor_id=".$id."&editor_name=".$name."' title='"._ME_EDITOR_OP_DEL."' name='"._ME_EDITOR_OP_DEL."' alt='"._ME_EDITOR_OP_DEL."'>\n";
        echo "<img alt='"._ME_EDITOR_OP_DEL."' src='".XOOPS_URL."/modules/multieditor/images/icons/delete.gif' />\n";
        echo "</a>\n";
        echo "</td>\n";
        echo "</tr>\n";
        }
    
    echo "<br />\n";
    echo "<tr class='odd'>\n";
    echo "<td>"."ID"."</td>\n";
    echo "<td><input type='text' id='new_name' name='new_name' size='18' /></td>\n";
    echo "<td><input type='text' id='new_class' name='new_class' size='24' /></td>\n";
    echo "<td><input type='text' id='new_path' name='new_path' size='50' /></td>\n";
    echo "<td><input type='text' id='new_weight' name='new_weight' size='2' /></td>\n";
    echo "<td><input type='radio' id='default' name='default' value='new' /></td>\n";
    echo "<td></td>\n";
    echo "</tr>\n";
    echo "<tr class='odd'>\n";
    echo "<td colspan='7'><input type='submit' name='op' id='op' value='submit'> <input type='reset' name='op' id='op' value='"._ME_EDITOR_OP_CANCEL."'></td>\n";
    echo "</tr>\n";
    echo "</tbody>\n";
    echo "</table>\n";
    echo "</form>\n";
    xoops_cp_footer();
    }



if ($op=='submit')
    {
    //get old editors values from post
    $old_editors = array();
    if (isset($_POST['_name']))
        {
        foreach ($_POST['_name'] as $id => $name)
            {
            $old_editors[$id]['id'] = $id;
            $old_editors[$id]['name'] = $name;
            if (empty($name))
                redirect_header('editors.php?op=list', 4, "ERRORE: dati errati");        
            $old_editors[$id]['class'] = $_POST['_class'][$id];
            $old_editors[$id]['path'] = $_POST['_path'][$id];
            $old_editors[$id]['weight'] = $_POST['_weight'][$id];
            $old_editors[$id]['default'] = '0';
            }
        }

    //get new editor values from post
    $new_name=$_POST['new_name'];
    $new_class=$_POST['new_class'];
    $new_path=$_POST['new_path'];
    $new_weight=$_POST['new_weight'];

    // check values
    if ($_POST['default'] != 'new')
        $old_editors[$_POST['default']]['default'] = '1';
    if (empty($_POST['new_name']) && $_POST['default'] == 'new')
        redirect_header('editors.php?op=list',4,""._ME_EDITOR_ED_DB_DATA_ERROR."");
    if (!empty($_POST['new_name']) && empty($_POST['_name']))
        $new_default = '1';

    //update old editors in database
    foreach ($old_editors as $old_editor)
        {
        $sql = "UPDATE ".$xoopsDB->prefix("multieditor_editors");
        $sql.= " SET";
        $sql.= " multied_name='".$old_editor['name']."',";
        $sql.= " multied_class='".$old_editor['class']."',";
        $sql.= " multied_path='".$old_editor['path']."',";
        $sql.= " multied_weight='".$old_editor['weight']."',";
        $sql.= " multied_default='".$old_editor['default']."'";
        $sql.= " WHERE multied_id='".$old_editor['id']."'";
        $old_query=$xoopsDB->queryF($sql);
        if(!$old_query) die($xoopsDB->error());
        }

    //insert new editor in database
    if (!empty($_POST['new_name']))
        {
        if ($_POST['default'] == 'new') $new_default = '1';
        $sql = "INSERT ";
        $sql.= "INTO ".$xoopsDB->prefix("multieditor_editors");
        $sql.= " (multied_name,multied_class,multied_path,multied_weight,multied_default)";
        $sql.= " VALUES ('$new_name','$new_class','$new_path','$new_weight','$new_default')";
        $new_query=$xoopsDB->queryF($sql);
        if(!$new_query) die($xoopsDB->error());
        }

    //if no errors
    redirect_header('editors.php',4,""._ME_EDITOR_ED_DB_UPDATE_OK."");
    }



if ($op=='delete')
    {
    xoops_cp_header();
    $editor_id = intval($_GET['editor_id']);
    $editor_name = htmlspecialchars(stripslashes($_GET['editor_name']),ENT_QUOTES);
    xoops_confirm(array( 'op' => 'delete_ok', 'editor_id' => $editor_id, 'editor_name' => $editor_name, 'ok' => 1), 'editors.php?op=list', _ME_EDITOR_DEL_CONFIRM." ".$editor_name."");
    xoops_cp_footer();
    }

if ($op=='delete_ok')
    {
    if (isset($_POST['ok'])) $ok = trim($_POST['ok']);
    if (isset($_POST['editor_id'])) $editor_id = trim($_POST['editor_id']);
    if (isset($_POST['editor_name'])) $editor_name = trim($_POST['editor_name']);

    $sql = "DELETE ";
    $sql.= "FROM ".$xoopsDB->prefix("multieditor_editors");
    $sql.= " WHERE multied_id=".$editor_id."";
    $query=$xoopsDB->queryF($sql);
    if(!$query) die($XoopsDB->error());
    else
        redirect_header('editors.php',4,''._ME_EDITOR_ED_DB_UPDATE_OK.'');
    }

?>
