<?php
/*
// error handler (beta)
function myErrorHandler ($error_level, $error_message, $error_file, $error_line, $error_context) {
  switch ($error_level) {
  case FATAL:
  case E_USER_ERROR:
    echo "<b>FATAL</b> [$error_level] $error_message<br>\n";
    echo "  Fatal error in line ".$error_line." of file ".$error_file;
    echo ", PHP ".PHP_VERSION." (".PHP_OS.")<br>\n";
    echo "Aborting...<br>\n";
    //exit 1;
    break;
  case ERROR:
  case E_USER_WARNING;
    echo "<b>ERROR</b> [$error_level] $error_message<br>\n";
    break;
  case WARNING:
  case E_USER_NOTICE:
    echo "<b>WARNING</b> [$error_level] $error_message<br>\n";
    break;
    default:
    echo "Unkown error type: [$error_level] $error_message<br>\n";
    break;
  }
}
*/
include_once 'admin_header.php';

$op = 'list';

if (isset($_POST['op']))
    $op = trim($_POST['op']);
elseif (isset($_GET['op']))
    $op = trim($_GET['op']);

$module_id = $xoopsModule->getVar('mid');

global $xoopsDB, $xoopsConfig, $xoopsModule;


// check Xoops version
if (XOOPS_VERSION) $xoops_version = split('[ .]',XOOPS_VERSION);
if ($xoops_version && XOOPS_VERSION && (($xoops_version[1]>2) || (($xoops_version[1]==2) && ($xoops_version[2]>=3))))
    {
    // Xoops >= 2.3.0 - start
    if (function_exists('xoops_load'))
        {
        //clear cache - start
        xoops_load('cache');
        XoopsCache::clear('editorlist');
        //clear cache - end
        xoops_load('XoopsEditorHandler');
        $editor_handler =& XoopsEditorHandler::getInstance();
        $list = array_keys($editor_handler->getList());
        //print_r($list);// debug
        foreach ($list as $name)
            {
            $editor = null;
        //  $editor_path = $this->root_path."/".$name;
            $editor_path = XOOPS_ROOT_PATH."/class/xoopseditor"."/".$name;
            if ( !include_once $editor_path."/language/" . $GLOBALS["xoopsConfig"]['language'] . ".php" ) {
                include_once $editor_path."/language/english.php";
            }
            if ((include $editor_path."/editor_registry.php") && (isset ($config)))
                {
                $editor['name'] = $config['title'];
                $editor['class'] = $config['class'];
                $editor['class_path'] = str_replace(XOOPS_ROOT_PATH, '', $config['file']);
                $editor['module_dirname'] = (array_key_exists('module_dirname',$editor)?$editor['module_dirname']:'');
                $editor['project'] = (array_key_exists('project',$editor)?$editor['project']:'');
                $editor['isnew'] = true;
                $editors[] = $editor;
                unset($editor);
                unset($config);
                }
            }
        }
    // Xoops >= 2.3.0 - end
    }
else
    {
    // Xoops < 2.3.0 - start
    $plugins_path = XOOPS_ROOT_PATH."/modules/multieditor/plugins/editors/";
    $plugins_dir = dir($plugins_path);
    $editors = array();
    while (false !== ($entry = $plugins_dir->read()))
        {
        $file = $plugins_path.$entry;
        if( $entry != '.' && $entry != '..' && basename($file) != 'index.html' )
            {
            // load editor data from plugin into $editors[] array
            include_once($file);
            $editor['isnew'] = false;
            $editors[] = $editor;
            unset($editor);
            }
        }
    $plugins_dir->close();
    // Xoops < 2.3.0 - end
    }



if ($op=='list')
    {
    xoops_cp_header();
    adminMenu(0,_ME_MULTIED_CHECK_ED);
    echo "<fieldset><legend>"._ME_INST_ED_NOTE."</legend>";
    echo _ME_INST_ED_DESCRIPTION;
    echo "</fieldset>";

    echo "<br />";

    echo "<fieldset><legend>"._ME_INST_ED_LEGENDA."</legend>";
    // legend - start
    echo '<table width="100%" align="center" border="0" cellpadding="5" cellspacing="0">';
    echo '<tr>';
    echo '<td width="50%"><img src="../images/icons/on.gif" alt=""align="absmiddle" />&nbsp;'._ME_INST_ED_OK.'</th>';
    echo '<td width="50%"><img src="../images/icons/off.gif" alt=""align="absmiddle" />&nbsp;'._ME_INST_ED_NOFILE.'</th>';
    echo '</tr>';
    echo '<tr>';
    echo '<td width="50%"><img src="../images/icons/notinstalled.gif" alt=""align="absmiddle" />&nbsp;'._ME_INST_ED_NOMODFILE.'</th>';
    echo '<td width="50%"><img src="../images/icons/noclass.gif" alt=""align="absmiddle" />&nbsp;'._ME_INST_ED_NOMODNOFILE.'</th>';
    echo '</tr>';
    echo '</table>';
    // legend - end
    echo "</fieldset>";

    echo "<br />";

    echo "<fieldset><legend>"._ME_INST_ED_LIST."</legend>";
    echo '<table width="100%" class="outer">';
    echo '<tr>';
    echo '<td colspan="2" align="center">';
    echo '</td>';
    echo '</tr>';
    echo '<tr>';
    echo '<th align="center">'._ME_INST_ED_STATUS.'</th>';
    echo '<th align="center">'._ME_INST_ED_NAME.'</th>';
    echo '<th align="center">'._ME_INST_ED_CLASS.'<br />'._ME_INST_ED_PATH.'</th>';
    //echo '<th align="center">'._ME_INST_ED_PATH.'</th>';
    echo '<th align="center">'._ME_INST_ED_MOD_DIR.'</th>';
    echo '<th align="center" style="width:40px">'._ME_INST_ED_OPERATION.'</th>';
    echo '</tr>';
    foreach ($editors as $key => $editor)
        {
        //check if editor is a module
        $isModule = false;
        if ($editor['module_dirname']!='')
            {
            $hModule = &xoops_gethandler('module');
            $Module = $hModule->getByDirname( $editor['module_dirname'] );
            $isModule = $Module;
            }
        else
            {
            $editor['module_dirname'] = '';
            }
    
        // check if file, class and render method exists
        $fileExist = false;
        $classExist = false;
        $render_menthodExist = false;
        if ($editor['class_path'] && $editor['class'])
            {
            // check if file exist
            $editor_path = XOOPS_ROOT_PATH.$editor['class_path'];
            $fileExist = is_readable(XOOPS_ROOT_PATH.$editor['class_path']);
        
            // check if class and render method exist    
    /*
            if ($fileExist)
                {
                // change error handler and error reporting setting
                //$old_error_reporting = error_reporting (E_USER_ERROR | E_USER_WARNING | E_USER_NOTICE);
                //$old_error_handler = set_error_handler("myErrorHandler");
                //include_once($editor_path);
                // reset error handler and error reporting setting
                //set_error_handler($old_error_handler);
                //error_reporting($old_error_reporting);
                if (class_exists($editor['class'], false))
                    {
                    $classExist = true;
                    $classMetods = get_class_methods($editor['class']);
                    $render_menthodExist = in_array('render', $classMetods);
                    }
                }
        $classAllRight = ($fileExist && $classExist && $render_menthodExist);
    */
            }
        $classAllRight = ($fileExist && $editor['class']);
        $editorIsInsallable = false;
        echo '<tr>';
        // Check editor class file
            echo '<td class="even" align="center">';
        // is a module and correctly installed
        if ($editor['module_dirname'] && $isModule && $classAllRight)
            {
            $editorIsInsallable = true;
            echo '<img src="../images/icons/on.gif" alt="'._ME_INST_ED_OK.'"align="absmiddle" />';
            }
        // is a module but not installed
        elseif ($editor['module_dirname'] && !$isModule && $classAllRight)
            {
            $editorIsInsallable = false;
            echo '<img src="../images/icons/notinstalled.gif" alt="'._ME_INST_ED_NOMODFILE.'"align="absmiddle" />';
            }
        // is a module intalled but classfile/class/render method not exist/s
        elseif ($editor['module_dirname'] && $isModule && !$classAllRight)
            {
            $editorIsInsallable = false;
            echo '<img src="../images/icons/noclass.gif" alt="'._ME_INST_ED_NOMODNOFILE.'"align="absmiddle" />';
            }    
        // is not a module and classfile, class, render method exists
        elseif ($editor['class_path'] && $editor['class'] && !$isModule && $classAllRight)
            {
            $editorIsInsallable = true;
            echo '<img src="../images/icons/on.gif" alt="'._ME_INST_ED_OK.'"align="absmiddle" />';
            }
        // is not a module and classfile/class/render method not exist/s
        elseif ($editor['class_path'] && $editor['class'] && !$isModule && !$classAllRight)
            {
            echo '<img src="../images/icons/off.gif" alt="'._ME_INST_ED_NOFILE.'"align="absmiddle" />';
            }
        echo '</td>';
    
        // Editor's name and link
        echo '<td class="odd">';
        if ($editor['project']!='') echo '<a target="_blank" href="' .$editor['project']. '">';
        echo '<b>'.$editor['name'].'</b>';
        if ($editor['project']!='') echo '</a>';
        echo '</td>';
        echo '<td class="odd">';
        echo $editor['class'];
        echo '<br />';
        echo $editor['class_path'];
        echo '</td>';
        echo '<td class="odd">'.$editor['module_dirname'].'</td>' ;
        echo '<td class="odd" style="width:40px">';
        if ($editorIsInsallable==true)
            {
            echo "<img alt='"._ME_INST_ED_OP_TEST."' onclick='javascript:openWithSelfMain(\"test_editor.php?class=".$editor['class']."&path=".$editor['class_path']."\",\"testeditor\",800,430);' src='".XOOPS_URL."/modules/multieditor/images/icons/test.gif' />";            
            echo "&nbsp;";
            echo "<a href='check_editors.php?op=add&editor_id=".$key."' title='"._ME_INST_ED_OP_ADD."' name='"._ME_INST_ED_OP_ADD."' alt='"._ME_INST_ED_OP_ADD."'>";
            echo "<img alt='"._ME_INST_ED_OP_ADD."' src='".XOOPS_URL."/modules/multieditor/images/icons/add.gif' />";
            echo "</a>";
            }
        echo "</td>" ;
        echo "</tr>";
        }
    echo "</table>";
echo "</fieldset>";
    xoops_cp_footer();
    }


if ($op=='add')
    {
    //get old editors values from post
// ATTENZIONE !!!!!!!!!!!!!!!!!!!!!!!!!!!
    if (isset($_GET['editor_id']))
        $key = trim($_GET['editor_id']);
    else
        redirect_header('check_editors.php',2,""._ME_INST_ED_NO_PARAM."");
    $name = $editors[$key]['name'];
    $class = $editors[$key]['class'];
    $class_path = $editors[$key]['class_path'];
    $isnew = ($editors[$key]['isnew']?$editors[$key]['isnew']:false);

    $sql = "INSERT ";
    $sql.= "INTO ".$xoopsDB->prefix("multieditor_editors");
    $sql.= " (multied_name,multied_class,multied_path,multied_weight,multied_default,multied_isnew)";
    $sql.= " VALUES ('$name','$class','$class_path','0','0','$isnew')";
    $new_query=$xoopsDB->queryF($sql);
    if(!$new_query) die($xoopsDB->error());

    //if no errors
    redirect_header('check_editors.php',4,""._ME_INST_ED_EDITOR." ".$name."<br />"._ME_EDITOR_ED_DB_UPDATE_OK."");
    }
?>
