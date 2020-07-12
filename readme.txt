MULTIEDITOR module
******************

by luciorota (lucio.rota@gmail.com)
!!!This is my FIRST module ;-)

credits:
from module : xoopsinfo 2.11
       site : http://www.dugris.info
    authors : - Jmorris
              - Marco
              - Christian
              - DuGris (http://www.dugris.info)

from module : TinyEditor v1.0
    authors : - ralf57
*********************


DESCRIPTION
*********************

Multimenu module allows Xoops adminstrators to set, for any module, group and
textarea which editor will be used.
*********************


INSTALL
*********************

To install (Xoops v2.0.14 - v2.0.18.2) please follow those instructions.

1. install this module in Administartion menu
2. patch "class/xoopsform/formdhtmltextarea.php" has described here 

ORIGINAL:
[code]
function XoopsFormDhtmlTextArea($caption, $name, $value, $rows=5, $cols=50, $hiddentext="xoopsHiddenText", $options = array() )
{
	$this->XoopsFormTextArea($caption, $name, $value, $rows, $cols);
	$this->_hiddenText = $hiddentext;
	
	if ( !empty( $this->htmlEditor ) ) {
		$options['name'] = $this->_name;
		$options['value'] = $this->_value;
[/code]

PATCHED:
[code]
function XoopsFormDhtmlTextArea($caption, $name, $value, $rows=5, $cols=50, $hiddentext="xoopsHiddenText", $options = array() )
{
	$this->XoopsFormTextArea($caption, $name, $value, $rows, $cols);
	$this->_hiddenText = $hiddentext;

include(XOOPS_ROOT_PATH."/modules/multieditor/multieditor_include.php"); // multieditor patch!
	
	if ( !empty( $this->htmlEditor ) ) {
		$options['name'] = $this->_name;
		$options['value'] = $this->_value;
[/code]

*********************

To install (Xoops v2.3.0) please follow those instructions.

1. install this module in Administartion menu
2. patch "class/xoopsform/formdhtmltextarea.php" has described here 

ORIGINAL:
[code]
function XoopsFormDhtmlTextArea($caption, $name, $value = "", $rows = 5, $cols = 50, $hiddentext = "xoopsHiddenText", $options = array() )
{
    static $inLoop = 0;
    
    $inLoop ++;
[/code]

PATCHED:
[code]
function XoopsFormDhtmlTextArea($caption, $name, $value = "", $rows = 5, $cols = 50, $hiddentext = "xoopsHiddenText", $options = array() )
{
include(XOOPS_ROOT_PATH."/modules/multieditor/multieditor_include.php"); // multieditor patch!
    static $inLoop = 0;
    
    $inLoop ++;
[/code]

*********************


CHANGELOG
*********************
v0.03 second beta release
v0.02 first beta release
v0.01 first alpha release
