<?php
require_once 'EmailPrecsser.class.php';
$test = new EmailPrecsser();

//Example 1: convert html string with no external css
/***************************************************/
//html to be converted
$html = <<<HTML
<html>
<head>
<style>
#title{
	color: #000000;
	font-size: 20px;
}
.has-strike{
	text-decoration: line-through;
}

p.has-strike.red-txt {
	font-weight: bold;
	color: red;
}
div#area-1{
	width: 200px;
	height: 200px;
	background-color: #666666;
}
div#area-1 div#inside-area-1{
	width: 50px;
	height: 50px;
	background-color: #cccccc;
}
.outer .inner{
	background-color: blue;
}
</style>
</head>
<body>
<h1 id="title">Test Title</h1>
<p style="width:100%;" class="has-strike red-txt" id="red">This is just a paragraph, a paragraph with strike through and red color.</p>
<p class="has-strike">another paragraph.</p>
<div id="area-1">
	<div id="inside-area-1"></div>
</div>
<p class="outer">This a paragraph with an <span class="inner">inner span of text</span> to test the nested styles.</p>
</body>
</html>
HTML;

//Process (well, or precss) the HTML source using the precss function
//precss(HTML_SOURCE_URL_OR_STRING_OF_HTML_DOCUMENT, FLAG_TRUE_IF_THE_SOURCE_IS_URL_FALSE_OTHERWISE)
echo $test->precss($html, false);

?>
