<?php
/**
 * This is a Leaf pagecontroller.
 *
 */
// Include the essential config-file which also creates the $leaf variable with its defaults.
include(__DIR__.'/config.php');
// Prepare the content
$html = <<<EOD
Detta är ett exempel på markdown
=================================
En länk till [Markdowns hemsida](http://daringfireball.net/projects/markdown/).
EOD;

$bbcodetest = <<<EOD
[b]BBCode.[/b]
Detta är ett [i]exempel[/i] på [u]BBCode[/u] kört genom [code]bbcode2html()[/code]. Läs mer på [url]http://sv.wikipedia.org/wiki/BBCode[/url].
EOD;

$linktest = <<<EOD
Vi testar metoden makeClickable() genom att skriva in en länk här: http://dbwebb.se
EOD;

$newlinetest = <<<EOD
\nDet här textstycket\ntestar nl2br() så att\nradbrytningar får\nkorrekt HTML-tag.
EOD;

$markdowntest = <<<EOD
Markdown test
-------------
Det här stycket testar metoden för **markdown-formatering** och ligger under en *Heading 2*.
###Underrubrik
Ytterligare ett stycke som ligger under en *Heading 3*.
EOD;

$filtertest = <<<EOD
###Filtertest med flera filter
Det här stycket testar **markdown** och makeClickable(): http://dbwebb.se
EOD;

$typographytest = <<<EOD
Let's try the typography filter. This is "double quotation marks".

These are 'single quotation marks'.

This is a -- n dash.

This should be an ellipse...
EOD;

$purifytest = <<<EOD
This is a demo page with some HTML code intended to run through <a href='http://htmlpurifier.org/'>HTMLPurify</a>. Edit the source and insert HTML code and see if it works.

<b>Text in bold</b> and <i>text in italic</i> and <a href='http://dbwebb.se'>a link to dbwebb.se</a>. JavaScript, like this: <javascript>alert('hej');</javascript> should however be removed.
EOD;

// Filter the content
$filter = new CTextFilter();
$html = $filter->doFilter($html, "markdown");

//$bbcodetest = $filter->doFilter($bbcodetest, "bbcode");
$bbcodetest = $filter->bbcode2html($bbcodetest);

$linktest = $filter->makeClickable($linktest);

$newlinetest = $filter->nl2br($newlinetest);

//$markdowntest = $filter->markdown($markdowntest);
$markdowntest = $filter->doFilter($markdowntest, "markdown");

$filtertest = $filter->doFilter($filtertest, "markdown,clickable");

$typographytest = $filter->doFilter($typographytest, "typography");

$purifytest = $filter->doFilter($purifytest, "purify");

// Do it and store it all in variables in the Leaf container.
$leaf['title'] = "Textfilter";
$leaf['main'] = '<article>' . $html . '<p>' . $bbcodetest . '<br>' . $linktest . $newlinetest . '</p>' . $markdowntest . $filtertest;
$leaf['main'] .= '<p>' . $typographytest . '</p>';
$leaf['main'] .= '<p>' . $purifytest . '</p></article>';
// Finally, leave it all to the rendering phase of Leaf.
include(LEAF_THEME_PATH);