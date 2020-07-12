<?php
function adminMenu ($currentoption = 0, $breadcrumb = '')
    {
    /* Nice button styles */
    ?><style type="text/css">
    #buttontop { float:left; width:100%; background: #e7e7e7; font-size:93%; line-height:normal; border-top: 1px solid #b7ae88; border-left: 1px solid #b7ae88; border-right: 1px solid #b7ae88; margin: 0; }
    #buttonbar { float:left; width:100%; background: #e7e7e7 url("../images/bg.gif") repeat-x left bottom; font-size:93%; line-height:normal; border-left: 1px solid #b7ae88; border-right: 1px solid #b7ae88; margin-bottom: 12px; }
    #buttonbar ul { margin:0; margin-top: 15px; padding:10px 10px 0; list-style:none; }
    #buttonbar li { display:inline; margin:0; padding:0; }
    #buttonbar a { float:left; background:url("../images/left_both.gif") no-repeat left top; margin:0; padding:0 0 0 9px; border-bottom:1px solid #b7ae88; text-decoration:none; }
    #buttonbar a span { float:left; display:block; background:url("../images/right_both.gif") no-repeat right top; padding:5px 15px 4px 6px; font-weight:bold; color:#765; }
    /* Commented Backslash Hack hides rule from IE5-Mac \*/
    #buttonbar a span {float:none;}
    /* End IE5-Mac hack */
    #buttonbar a:hover span { color:#272727; }
    #buttonbar #current a { background-position:0 -150px; border-width:0; }
    #buttonbar #current a span { background-position:100% -150px; padding-bottom:5px; color:#272727; }
    #buttonbar a:hover { background-position:0% -150px; }
    #buttonbar a:hover span { background-position:100% -150px; }
    .tdbuttonsmall, .tdbuttonsmall_off { vertical-align: top; border: 0px #cccccc solid; padding: 3px; }
    .tdbuttonsmall_off {filter: alpha(opacity=30); -moz-opacity: 0.3; opacity: 0.30; }
    .subtitle { font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 14px; font-weight: bold; }
    </style><?php
    global $xoopsDB, $xoopsModule, $xoopsConfig, $xoopsModuleConfig;
    $x22 = false;
    $xv = str_replace('XOOPS ','',XOOPS_VERSION);
    if (substr($xv,2,1)=='2') {
        $x22 = true;
    }
    $tblCol = array();
    if (strtoupper(substr(PHP_OS, 0, 3)) != 'WIN')
        $tblCol[0]=$tblCol[1]=$tblCol[2]=$tblCol[3]='';
    else
        $tblCol[0]=$tblCol[1]=$tblCol[2]=$tblCol[3]='';
    
    $tblCol[$currentoption] = 'current';

    echo "<div id='buttontop'>";
    echo "<table style=\"width: 100%; padding: 0; \" cellspacing=\"0\"><tr>";
    echo "<td style='width: 50%; font-size: 10px; text-align: left; color: #2F5376; padding: 0 6px; line-height: 18px;'>";
    echo "<b>".$xoopsModule->name()." - "._ME_MULTIED_ADMIN."</b>";
    echo "</td>";
    /*
    echo "<td style='width: 50%; font-size: 10px; text-align: right; color: #2F5376; padding: 0 6px; line-height: 18px;'>";
    echo "<a class='nobutton' href='#'>"."item 1"."</a> | <a class='nobutton' href='#'>"."item 2"."</a>";
    echo "</td>";
    */
    echo "</tr></table>";
    echo "</div>";

    echo "<div id='buttonbar'>";
    echo "<ul>";
    echo "<li id='".$tblCol[0]."'><a href=\"index.php\"><span>"._ME_MULTIED_CHECK_ED."</span></a></li>";
    echo "<li id='".$tblCol[1]."'><a href=\"editors.php\"><span>"._ME_MULTIED_ED_LIST."</span></a></li>";
    echo "<li id='".$tblCol[2]."'><a href=\"permissions.php\"><span>"._ME_MULTIED_MOD_GROUP_ARRAY."</span></a></li>";
     echo "<li id='".$tblCol[3]."'><a href=\"help.php\"><span>"._ME_MULTIED_ABOUT."</span></a></li>";

    echo "</ul></div>";
    echo "<br style='clear:both;' />";
    }
?>
