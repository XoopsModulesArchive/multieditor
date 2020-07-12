<?php
/**
 * Is Xoops 2.3.x ?
 *
 * @return boolean need to say it ?
 */
function isX23()
    {
    $x23 = false;
    $xv = str_replace('XOOPS ','',XOOPS_VERSION);
    if(substr($xv,2,1) == '3') {
        $x23 = true;
        }
    return $x23;
    }

function curPageURL($complete = "true")
    {
    $isHTTPS = (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on");
    $port = (isset($_SERVER["SERVER_PORT"]) && ((!$isHTTPS && $_SERVER["SERVER_PORT"] != "80") || ($isHTTPS &&     $_SERVER["SERVER_PORT"] != "443")));
    $port = ($port) ? ':'.$_SERVER["SERVER_PORT"] : '';
    $url = ($isHTTPS ? 'https://' : 'http://').$_SERVER["SERVER_NAME"].$port.$_SERVER["REQUEST_URI"];
    if (!$complete)
        {
        $url = explode(XOOPS_URL,$url);
        $url = $url[1];
        } 
    return $url;
    }



function curPageName()
    {
    return substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);
    }



function get_default_editor()
    // returns an array like this
    // $editor["id"]
    // $editor["name"]
    // $editor["class"]
    // $editor["path"]
    // $editor["weight"]
    // $editor["default"]
    {
    global $xoopsDB;
    // get editor with default flag true 
    $default_sql = "SELECT *";
    $default_sql.= " FROM ". $xoopsDB->prefix('multieditor_editors');
    $default_sql.= " WHERE multied_default = true";
    $default_sql.= " ORDER BY multied_weight ASC";
    $default_query = $xoopsDB->query($default_sql);
    if (!$default_query) die($xoopsDB->error());
    if ($xoopsDB->getRowsNum($default_query)==1)
        {
        while($myrow = $xoopsDB->fetchArray($default_query))
            {
            $return["id"] = $myrow['multied_id'];
            $return["name"] = $myrow['multied_name'];
            $return["class"] = $myrow['multied_class'];
            $return["path"] = $myrow['multied_path'];
            $return["weight"] = $myrow['multied_weight'];
            $return["default"] = $myrow['multied_default'];
            }
        return $return;
        }

    // get editor with the lowerest weight
    $weight_sql = "SELECT *";
    $weight_sql.= " FROM ". $xoopsDB->prefix('multieditor_editors');
    $weight_sql.= " ORDER BY multied_weight ASC";
    $weight_sql.= " LIMIT 0,1";
    $weight_query = $xoopsDB->query($weight_sql);
    if (!$weight_query) die($xoopsDB->error());
    if ($xoopsDB->getRowsNum($weight_query)==1)
        {
        while($myrow = $xoopsDB->fetchArray($weight_query))
            {
            $return["id"] = $myrow['multied_id'];
            $return["name"] = $myrow['multied_name'];
            $return["class"] = $myrow['multied_class'];
            $return["path"] = $myrow['multied_path'];
            $return["weight"] = $myrow['multied_weight'];
            $return["default"] = $myrow['multied_default'];
            }
        return $return;
        }
    
    // non editor choosen
    return false;
    }



function get_editors_list()
    // returns an editors array like this
    // $editor[]["id"]
    // $editor[]["name"]
    // $editor[]["class"]
    // $editor[]["path"]
    // $editor[]["weight"]
    // $editor[]["default"]
    {
    global $xoopsDB;
    $return_array = array();
    // get editor list 
    $editors_sql = "SELECT *";
    $editors_sql.= " FROM ". $xoopsDB->prefix('multieditor_editors');
    $editors_sql.= " ORDER BY multied_id ASC";
    $editors_query = $xoopsDB->query($editors_sql);
    if (!$editors_query) die($xoopsDB->error());
    while($myrow = $xoopsDB->fetchArray($editors_query))
        {
        $editor["id"] = $myrow['multied_id'];
        $editor["name"] = $myrow['multied_name'];
        $editor["class"] = $myrow['multied_class'];
        $editor["path"] = $myrow['multied_path'];
        $editor["weight"] = $myrow['multied_weight'];
        $editor["default"] = $myrow['multied_default'];
        $return_array[] = $editor; 
        }
    return $return_array;
    // no editor choosen
    return false;
    }



function get_editor_by_id($id)
    // returns an array like this
    // $editor["id"]
    // $editor["name"]
    // $editor["class"]
    // $editor["path"]
    // $editor["weight"]
    // $editor["default"]
    {
    global $xoopsDB;
    
    if (!isset($id))
        {
        $default_editor = get_default_editor();
        $id = $default_editor['id'];
        }
    // get editor with default flag true 
    $editor_sql = "SELECT *";
    $editor_sql.= " FROM ". $xoopsDB->prefix('multieditor_editors');
    $editor_sql.= " WHERE multied_id = '".$id."'";
    $editor_query = $xoopsDB->query($editor_sql);
    if (!$editor_query) die($xoopsDB->error());
    while($myrow = $xoopsDB->fetchArray($editor_query))
        {
        $editor["id"] = $myrow['multied_id'];
        $editor["name"] = $myrow['multied_name'];
        $editor["class"] = $myrow['multied_class'];
        $editor["path"] = $myrow['multied_path'];
        $editor["weight"] = $myrow['multied_weight'];
        $editor["default"] = $myrow['multied_default'];
        }
    return $editor;
    }



function choose_editor()
    {
    // if user appartiene a ADMINISTRATOR Group use administrator setting
    // else
    // ordina editors per peso e scegli più pesante
    // else
    // scegli default editor
    global $xoopsDB,$xoopsUser;
    
    }



function purge_groups_modules_array()
    //
    {
    global $xoopsDB;
    $modules_Handler =& xoops_gethandler('module');
    $groups_Handler =& xoops_gethandler('group');

    $sql = "SELECT *";
    $sql.= " FROM ".$xoopsDB->prefix('multieditor_groups_modules_array'); 
    $query = $xoopsDB->query($sql);
    if (!$query) die($xoopsDB->error());
    while($myrow = $xoopsDB->fetchArray($query))
        {
        $group_id = $myrow['multigm_group_id'];
        $module_id = $myrow['multigm_module_id'];
    
        $keep_this = true;
        // delete "cell" if "$group_id" group or "$module_id" module not exists
        $module_exist = $modules_Handler->get($module_id);
        $group_exist = $groups_Handler->get($group_id);
        if (!$module_exist || !$group_exist)
            {
            $keep_this = false;
            $sql = "DELETE";
            $sql.= " FROM ".$xoopsDB->prefix('multieditor_groups_modules_array');
            $sql.= " WHERE multigm_group_id=".$group_id." AND multigm_module_id=".$module_id."";  
            $query = $xoopsDB->queryF($sql);
            if (!$query) die($xoopsDB->error());
            // CREARE UN CONTROLLO DI VERIFICA
            }
        }
    }



function get_group_module_editor($module_id,$group_id)
    // returns an array like this
    // $return["module_id"]
    // $return["group_id"]
    // $return["editor_id"]
    // $return["textarea"]
    // return "false" if group or module not exists or in case of any error
    {
    global $xoopsDB;
    $return["module_id"]=$module_id;
    $return["group_id"]=$group_id;
    $return["editor_id"]=null;
    $return["textarea"]=null;
    $sql = "SELECT *";
    $sql.= " FROM ".$xoopsDB->prefix('multieditor_groups_modules_array');
    $sql.= " WHERE multigm_module_id=".$module_id." AND multigm_group_id=".$group_id."";
    $query = $xoopsDB->query($sql);
    if (!$query) die($xoopsDB->error());
    // check array integrity
    if ($xoopsDB->getRowsNum($query)==1)
        {
        while($myrow = $xoopsDB->fetchArray($query))
            {
            $return["editor_id"] = $myrow['multigm_editor_id'];
            $return["textarea"] = $myrow['multigm_textarea'];
            }
        return $return;
        }

    return false;
    }



function set_group_module_editor($module_id,$group_id,$editor_id=0,$textarea="")
    // return "true" in case of no problems
    // return "false" if group or module not exists or in case of any error
    {
    global $xoopsDB;
    // check if  module/group exists - start
    $modules_Handler =& xoops_gethandler('module');
    $groups_Handler =& xoops_gethandler('group');
    $module_exist = $modules_Handler->get($module_id);
    $group_exist = $groups_Handler->get($group_id);
    if (!$module_exist || !$group_exist) return false;
    // check if  module/group exists - end
    
    $sql = "SELECT *";
    $sql.= " FROM ".$xoopsDB->prefix('multieditor_groups_modules_array');
    $sql.= " WHERE multigm_module_id='".$module_id."' AND multigm_group_id='".$group_id."'";
    $query = $xoopsDB->query($sql);
    if (!$query) die($xoopsDB->error());
    // if not exist "cell"
    if ($xoopsDB->getRowsNum($query)==0)
        {
        $sql = "INSERT";
        $sql.= " INTO ".$xoopsDB->prefix('multieditor_groups_modules_array')."(multigm_module_id,multigm_group_id,multigm_editor_id,multigm_textarea)";
        $sql.= " VALUES('".$module_id."','".$group_id."','".$editor_id."','".$textarea."')";
        $insert_query = $xoopsDB->queryF($sql);
        if (!$insert_query) die($xoopsDB->error());
        //echo "INSERT";//debug
        }
    // if not exist 1! "cell"
    elseif ($xoopsDB->getRowsNum($query)==1)
        {
        $sql = "UPDATE ".$xoopsDB->prefix('multieditor_groups_modules_array')."";
        $sql.= " SET multigm_editor_id = '".$editor_id."',multigm_textarea ='".$textarea."'";  
        $sql.= " WHERE multigm_module_id='".$module_id."' AND multigm_group_id='".$group_id."'";
        $update_query = $xoopsDB->queryF($sql);
        if (!$update_query) die($xoopsDB->error());
        //echo "UPDATE";//debug
        }
    elseif ($xoopsDB->getRowsNum($query)>=2)
        {
        die("DATABASE ERROR: 'multieditor_groups_modules_array' table has duplicated cells");
        }
    }
?>
