<?php
include 'admin_header.php';
xoops_cp_header();
adminMenu(2, _ME_MULTIED_MOD_GROUP_ARRAY);

/*
* Set permissions
*/

// get installed modules - start
$module_Handler =& xoops_gethandler('module');
$moduleObjects =& $module_Handler->getObjects();
// get installed modules - end
// get groups- start
$member_Handler =& xoops_gethandler('member');
$groups =& $member_Handler->getGroups();
// get groups- end

purge_groups_modules_array();

$editors_array = get_editors_list();
if (!isset($editors_array) || !$editors_array)
	{
	redirect_header('editors.php',4,""._ME_MOD_GROUP_NO_EDITOR."");
	}
else
	{
	echo "<div>";
	echo "<fieldset>";
	echo "<legend style='font-weight: bold; color: #900;'>"._ME_MOD_GROUP_LEGEND."</legend>";
	echo "<div style='padding: 2px;'>";
	// modules groups array - start
	echo "<form name='modules_groups_array_form' id='modules_groups_array_form' action='permissions_insert.php' method='post'>";
	echo "<table class='outer' style='width:100%' cellspacing=1><tbody>";
	echo "<tr>";
	echo "<td class='even'>"._ME_MOD_GROUP_ARRAY."</td>";
	foreach ($groups as $group)
		{
		$group_id = $group->getVar('groupid');
		$group_name = $group->getVar('name');
		if (XOOPS_GROUP_ADMIN == $group_id || XOOPS_GROUP_USERS == $group_id || XOOPS_GROUP_ANONYMOUS == $group_id)
			{
			}
		echo "<td class='head'>";
		echo "".$group_name."";
		//echo ("<br />");
		//echo ("".$group_id."");
		echo "</td>";
		}
	echo "</tr>";
	foreach ($moduleObjects as $moduleObject)
		{
		$mod_dir_name = $moduleObject->getVar('dirname');
		$mod_dir = XOOPS_ROOT_PATH . '/modules/' . $mod_dir_name . '/';
		$mod_id = $moduleObject->getVar('mid');
		$mod_name = $moduleObject->getVar('name');
		$mod_isactive = $moduleObject->getVar('isactive');
		// check if module is active
		if ($mod_isactive)
			{
			echo "<tr>";
			echo "<td class='head'>";
			echo "".$mod_name."";
			//echo ("<br />id ".$mod_id."<br />directory ".$mod_dir_name."");//debug
			echo "</td>";
			foreach ($groups as $group)
				{
				$group_id = $group->getVar('groupid');
				$group_name = $group->getVar('name');
				if (XOOPS_GROUP_ADMIN == $group_id || XOOPS_GROUP_USERS == $group_id || XOOPS_GROUP_ANONYMOUS == $group_id)
					{
					}
				echo "<td class='even'>";
				$return = get_group_module_editor($mod_id,$group_id);
				$default_editor = get_default_editor();
				echo "<select name='editor_id[module_id][group_id][".$mod_id."][".$group_id."]' id='editor[module_id][group_id][".$mod_id."][".$group_id."]'>";
				echo "<option value ='' style='background-color:yellow;color:red;'".((!$return)?" selected='selected'":"").">"._ME_MOD_GROUP_DEFAULT.$default_editor['name']."</option>";
				foreach($editors_array as $id => $editor)
					{
					echo "<option value ='".$editor['id']."'".(($editor['id']==$return["editor_id"])?" selected='selected'":"").">(".$editor['id'].") ".$editor['name']."</option>";
					}
				echo "</select>";
	// in progress
	//			echo "<br />";
	//			echo "<input type='text' name='textarea[module_id][group_id][".$mod_id."][".$group_id."]' id='textarea[module_id][group_id][".$mod_id."][".$group_id."]'  value='".$return["textarea"]."'>";
	// in progress
				echo "</td>";
				}
			echo "</tr>";
			}
		}
	echo "</tbody></table>";
	// modules groups array - end
	echo "<input type='submit' class='formButton' name='submit'  id='submit' value='Invia' />";
	echo "<input type='reset' class='formButton' name='reset'  id='reset' value='Annulla' />";
	echo "<input type='hidden' name='permissions_insert' id='permissions_insert' value='true' />";
	echo "</form>";
	echo "</div>";
	echo "</fieldset>";
	echo "</div>";
	// modules groups array - end
	}

xoops_cp_footer();
?>
