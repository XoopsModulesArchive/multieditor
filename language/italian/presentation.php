<h1>Descrizione</h1>
<p>
	Questo modulo consente all'amministratore di impostare, per ogni modulo/gruppo quale editor utilizzare.
</p>
<h1>Crediti</h1>
<p>
	by luciorota (lucio.rota@gmail.com)
</p>
<p>
	<em>
		!!!Questo &egrave; il mio PRIMO modulo 
		<img alt="Molto Contento" border="0" src="http://localhost/xoops230/uploads/smil3dbd4d4e4c4f2.gif" title="Very Happy" />
	</em>
</p>
<p>
crediti:
</p>
<p>
	dal modulo : xoopsinfo 2.11
	<br />
	sito : http://www.dugris.info
	<br />
	autori : Jmorris, Marco, Christian, DuGris (http://www.dugris.info)
</p>
<p>
	dal modulo : TinyEditor v1.0
	<br />
	autori : - ralf57
</p>
<p>
	Un ringraziamento particolare va alle comunit&agrave;  
	<a href="http://www.xoopsitalia.org/">XoopsItalia</a>
	e 
	<a href="http://www.xoops.org/">Xoops</a>
	a tutti gli Xoopser del mondo...
</p>
<h1>Changelog</h1>
<p>
	v0.02 prima beta
</p>
<p>
	v0.01 prima alpha
</p>
<hr />
<h1>Installare</h1>
<p>
	<strong>Per installare (Xoops v2.0.14 - v2.0.18.2) seguire le seguenti instruzioni.</strong>
</p>
<ol>
	<li>installare il modulo nel Menu di Amministrazione</li>
	<li>modificare il file "class/xoopsform/formdhtmltextarea.php" come descritto qui</li>
</ol>
<p>
	ORIGINALE:
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
	MODIFICARE:
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
	<strong>Per installare (Xoops v2.3.0) seguire le seguenti instruzioni.</strong>
</p>
<ol>
	<li>installare il modulo nel Menu di Amministrazione</li>
	<li>modificare il file "class/xoopsform/formdhtmltextarea.php" come descritto qui</li>
</ol>
<p>
	ORIGINALE:
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
	MODIFIDCATO:
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
