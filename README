EmailPrecsser
=============
is a php class to prepare the HTML for an HTML email or just make all CSS blocks and stylesheets to be inline (why would you do that other than for an HTML email?) The class uses a CSS parser called csstidy and a HTML dom parser called ganon.

THE NAME:
EmailPrecss means email preparation of CSS

WHY?
Most if not all email clients and companies stip out some HTML elements from an HTML email for security reasons, in many cases no <script>, <style> or <head> tags will be left in the email. So to keep the look and the style of the email HTML you have to generate an HTML code with inline CSS. For example:
instead of
```html
<html>
<head>
<style>
  h1{
    color: red;
    font-size: bold;
  }
  p.sign{
    color: #cccccc;
    text-decoration: italic;
  }
</style>
</head>
<body>
<h1>Company Name</h1>
<p>Hi,<br />Thank you for contacting us via the support form, we will call you asap.<p>
<p class="sign">Support Team</p>
</body>
</html>
```

you would have to use something like:
```html
<html>
<body>
<h1 style="color: red; font-size: bold;">Company Name</h1>
<p>Hi,<br />Thank you for contacting us via the support form, we will call you asap.<p>
<p style="color: #cccccc; text-decoration: italic;">Support Team</p>
</body>
</html>
```

HOW CAN YOU AUTOMATICALLY GENERATE THAT?
Using EmailPrecsser, you can convert the first code to the second.

ALREADY THERE:
I am aware of many other libraries and classes that do the same thing, but for one of my projects I could not find any simple solution using those tools. Many tools seem to be very comlicated and hard to include in my scripts. EmailPrecsser should be easily included and gives some useful options to include HTML as string or from a URL. Same for the CSS.


Getting Started
===============
To use EmailPrecsser, first include the class file
```php
include 'EmailPrecsser.class.php';
```

Create an instance
```php
$email = new EmailPrecsser();
```

Call precss function with your HTML source and CSS source if any, see examples below:
Example 1:
----------
Convert html string with no external css
```php
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
echo $email->precss($html, false);
```

Example 2
---------
Convert HTML document with all the CSS and stylesheet files that it includes
```php
precss($source, $is_url, $base_url);
```
$source: 	the source of HTML
$is_url:	true if the source is an URL, false if it is a HTML string
$base_url:	the base url of the document, to modify any relative links

```php
echo $email->precss('http://www.example.com/page.html', true, 'http://www.example.com');
```

Example 3
---------
convert HTML document (url) with all the CSS and stylesheet files that it includes and include additional CSS source
```php
precss($source, $is_url, $base_url, $css);
```
$source:        the source of HTML
$is_url:        true if the source is an URL, false if it is a HTML string
$base_url:      the base url of the document, to modify any relative links
$css:		the additional CSS source sould be a string of CSS rules or a link to a stylesheet file

```php
echo $email->precss('http://www.example.com/page.html', true, 'http://www.example.com', 'h1{font-weight: bold;} p{color: red}');
```
OR
```php
echo $email->precss('http://www.example.com/page.html', true, 'http://www.example.com', 'http://www.example.com/style.css');
```


Additional Info:
================
The script is a work in progress, so it might have some issues. One of the known issues is that it is slow when the document has a lot of HTML elements. The reason for that is that there is a lot of iteration done on each element in addition to the CSS selectors to apply the style rules. This can be avoided if the HTML DOM parser that I used did not have a bug when traversing an element with multiple classes. I have reported the bug to ganon developer, and will replace that parser file if it gets fixed or if I find a better parser.

Simple_html_dom parser has the same issue when it comes to multiple classes elements.

Credits:
========
ganon HTML DOM parser http://code.google.com/p/ganon
csstidy CSS parser http://csstidy.sourceforge.net

Special thanks to Tim Wright for his help with regex patterns https://github.com/spartas

