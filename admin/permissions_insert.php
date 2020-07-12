<?php
include 'admin_header.php';

$posted_data = array();

// fills "$posted_data" array with posted "editor" values
if (is_array($_POST['editor_id']) && !empty($_POST['editor_id']))
    foreach ($_POST['editor_id'] as $index_1 => $data_1)
        foreach ($data_1 as $index_2 => $modules_ids)
            foreach ($modules_ids as $module_id => $groups_ids)
                foreach ($groups_ids as $group_id => $value)
                    {
                    //echo("module ".$module_id." - group ".$group_id." = ".$value."<br />");
                    $posted_data[$module_id][$group_id]['editor_id']=$value;
                    }
// fills "$posted_data" array with posted "textarea" values
if (is_array($_POST['textarea']) && !empty($_POST['textarea']))
    foreach ($_POST['textarea'] as $index_1 => $data_1)
        foreach ($data_1 as $index_2 => $modules_ids)
            foreach ($modules_ids as $module_id => $groups_ids)
                foreach ($groups_ids as $group_id => $value)
                    {
                    //echo("module ".$module_id." - group ".$group_id." = ".$value."<br />");//debug
                    $posted_data[$module_id][$group_id]['textarea']=$value;
                    }

$allright = true;
foreach ($posted_data as $module_id => $module_id_data)
    foreach ($module_id_data as $group_id => $group_id_data)
        {
        $editor_id = $group_id_data['editor_id'];
        $textarea = $group_id_data['textarea'];
        set_group_module_editor($module_id,$group_id,$editor_id,$textarea);
        }

// MANCANO TUTTE LE VERIFICHE DI CORRETTEZZA DATI...
if ($allright)
    redirect_header(XOOPS_URL."/modules/multieditor/admin/permissions.php",2,""._ME_MOD_GROUP_DB_UPDATE_OK."");
else
    redirect_header(XOOPS_URL."/modules/multieditor/admin/permissions.php",2,""._ME_MOD_GROUP_DB_DATA_ERROR."");
?>
