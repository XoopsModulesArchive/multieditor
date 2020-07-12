<?php
include "admin_header.php";
$module_handler = &xoops_gethandler('module');
$versioninfo = &$module_handler->get($xoopsModule->getVar('mid'));
xoops_cp_header();
adminMenu(6, _ME_MULTIED_HELP);

echo "<img src='" . XOOPS_URL . "/modules/" . $xoopsModule->getVar('dirname') . "/" . $versioninfo->getInfo('image') . "' alt='' hspace='0' vspace='0' align='left' style='margin-right: 10px;'/></a>";
echo "<div style='margin-top: 10px; color: #33538e; margin-bottom: 4px; font-size: 18px; line-height: 18px; font-weight: bold; display: block;'>" . $versioninfo->getInfo('name') . " version " . $versioninfo->getInfo('version') . "</div>";
if ($versioninfo->getInfo('author_realname') != '') {
    $author_name = $versioninfo->getInfo('author') . " (" . $versioninfo->getInfo('author_realname') . ")";
} else {
    $author_name = $versioninfo->getInfo('author');
} 

echo "<div style = 'line-height: 16px; font-weight: bold; display: block;'>" . _ME_HELP_AUTHOR . " " . $author_name;
echo "</div>";
echo "<div style = 'line-height: 16px; display: block;'>" . $versioninfo->getInfo('license') . "</div>\n";

echo "<br />";

// Module Development information
echo "<fieldset><legend>"._ME_HELP_INFO."</legend>";
echo "<table width='100%' cellspacing=1 cellpadding=1 border=0>";
//echo "<tr>";
//echo "<td class='bg3' align='left'><b>" . _AM_MULTI_DEVINFOS . "</b></td>";
//echo "</tr>";
echo "<tr>";
echo "<td class='even' align='left'><a href='#'>"._ME_HELP_DEVSITE."</a></td>";
echo "</tr>";
echo "<tr>";
echo "<td class='even' align='left'><a href='#'>"._ME_HELP_BUGSREP."</a></td>";
echo "</tr>";
echo "<tr>";
echo "<td class='even' align='left'><a href='#'>"._ME_HELP_RFEREP."</a></td>";
echo "</tr>";
echo "<tr>";
echo "<td class='even' align='left'><a href='#'>"._ME_HELP_FORUMS."</a></td>";
echo "</tr>";
echo "</table></fieldset>";


echo "<br />";


echo "<fieldset><legend>"._ME_HELP_INSTRUCTIONS."</legend>";

$xoopsConfig['language'] = preg_replace("/[^0-9a-z\-_,]+/i", "", $xoopsConfig['language']);
if (file_exists(XOOPS_ROOT_PATH."/modules/multieditor/language/".$xoopsConfig['language']."/presentation.php"))
    include XOOPS_ROOT_PATH."/modules/multieditor/language/".$xoopsConfig['language']."/presentation.php";
else
    include XOOPS_ROOT_PATH."/modules/multieditor/language/english/how_to.php";

echo "<hr />";

if (file_exists(XOOPS_ROOT_PATH."/modules/multieditor/language/".$xoopsConfig['language']."/how_to.php"))
    include XOOPS_ROOT_PATH."/modules/multieditor/language/".$xoopsConfig['language']."/how_to.php";
else
    include XOOPS_ROOT_PATH."/modules/multieditor/language/english/how_to.php";

echo "</fieldset>";

xoops_cp_footer();
?>
