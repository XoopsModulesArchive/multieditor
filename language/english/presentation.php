<h1>Description</h1>
<p>
	Multimenu module allows Xoops adminstrators to set, for any module, group and textarea which editor will be used.
</p>
<h1>Credits</h1>
<p>
	by luciorota (lucio.rota@gmail.com)
</p>
<p>
	<em>
		!!!This is my FIRST module 
		<img alt="Very Happy" border="0" src="http://localhost/xoops230/uploads/smil3dbd4d4e4c4f2.gif" title="Very Happy" />
	</em>
</p>
<p>
credits:
</p>
<p>
	from module : xoopsinfo 2.11
	<br />
	site : http://www.dugris.info
	<br />
	authors : Jmorris, Marco, Christian, DuGris (http://www.dugris.info)
</p>
<p>
	from module : TinyEditor v1.0
	<br />
	authors : - ralf57
</p>
<p>
	Very and very special Thanks to 
	<a href="http://www.xoopsitalia.org/">XoopsItalia</a>
	and 
	<a href="http://www.xoops.org/">Xoops</a>
	teams and to all Xoopers...
</p>
<h1>Changelog</h1>
<p>
	v0.02 first beta release
</p>
<p>
	v0.01 first alpha release
</p>
<hr />
<h1>Install</h1>
<p>
	<strong>To install (Xoops v2.0.14 - v2.0.18.2) please follow those instructions.</strong>
</p>
<ol>
	<li>install this module in Administartion menu</li>
	<li>patch "class/xoopsform/formdhtmltextarea.php" has described here </li>
</ol>
<p>
	ORIGINAL:
</p>
<div class="xoopsCode">
	function XoopsFormDhtmlTextArea($caption, $name, $value, $rows=5, $cols=50, $hiddentext=&quot;xoopsHiddenText&quot;, $options = array() )
	<br />
	&nbsp;&nbsp;&nbsp; {
	<br />
	&nbsp;&nbsp;&nbsp; $this-&gt;XoopsFormTextArea($caption, $name, $value, $rows, $cols);
	<br />
	&nbsp;&nbsp;&nbsp; $this-&gt;_hiddenText = $hiddentext;
	<br />
	&nbsp;&nbsp;&nbsp; if ( !empty( $this-&gt;htmlEditor ) )
	<br />
	&nbsp;&nbsp;&nbsp; {
	<br />
	&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; $options['name'] = $this-&gt;_name;
	<br />
	&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; $options['value'] = $this-&gt;_value;
</div>
<p>
	PATCHED:
</p>
<div class="xoopsCode">
	function XoopsFormDhtmlTextArea($caption, $name, $value, $rows=5, $cols=50, $hiddentext=&quot;xoopsHiddenText&quot;, $options = array() )
	<br />
	&nbsp;&nbsp;&nbsp; {
	<br />
	&nbsp;&nbsp;&nbsp; $this-&gt;XoopsFormTextArea($caption, $name, $value, $rows, $cols);
	<br />
	&nbsp;&nbsp;&nbsp; $this-&gt;_hiddenText = $hiddentext;
	<br />
	<span style="color:red;">&nbsp;&nbsp;&nbsp; include(XOOPS_ROOT_PATH.&quot;/modules/multieditor/multieditor_include.php&quot;); // multieditor patch!</span>
	<br />
	&nbsp;&nbsp;&nbsp; if ( !empty( $this-&gt;htmlEditor ) )
	<br />
	&nbsp;&nbsp;&nbsp; {
	<br />
	&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; $options['name'] = $this-&gt;_name;
	<br />
	&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; $options['value'] = $this-&gt;_value;
</div>
<p>
	<strong>To install (Xoops v2.3.0) please follow those instructions.</strong>
</p>
<ol>
	<li>install this module in Administartion menu</li>
	<li>patch "class/xoopsform/formdhtmltextarea.php" has described here </li>
</ol>
<p>
	ORIGINAL:
</p>
<div class="xoopsCode">
	function XoopsFormDhtmlTextArea($caption, $name, $value = &quot;&quot;, $rows = 5, $cols = 50, $hiddentext = &quot;xoopsHiddenText&quot;, $options = array() )
	<br />
	&nbsp;&nbsp;&nbsp; {
	<br />
	&nbsp;&nbsp;&nbsp; static $inLoop = 0;
	<br />
	&nbsp;&nbsp;&nbsp; $inLoop ++;
</div>
<p>
	PATCHED:
</p>
<div class="xoopsCode">
	function XoopsFormDhtmlTextArea($caption, $name, $value = &quot;&quot;, $rows = 5, $cols = 50, $hiddentext = &quot;xoopsHiddenText&quot;, $options = array() )
	<br />
	&nbsp;&nbsp;&nbsp; {
	<br />
	<span style="color:red;">&nbsp;&nbsp;&nbsp; include(XOOPS_ROOT_PATH.&quot;/modules/multieditor/multieditor_include.php&quot;); // multieditor patch!</span>
	<br />
	&nbsp;&nbsp;&nbsp; static $inLoop = 0;
	<br />
	&nbsp;&nbsp;&nbsp; $inLoop ++;
</div>
