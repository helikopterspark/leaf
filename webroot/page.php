<?php

/**
 * This a Leaf page controller
 * 
 */
// Include essential config-file which also creates the $leaf variable with its defaults
include (__DIR__ . '/config.php');

$cpage = new CPage($leaf['database']);
$pagecontent = $cpage->getPageContent();	// $pagecontent is an array
$aside = $cpage->getLinklist('page', 'html');
$editLink = $pagecontent['acronym'] ? "<a href='edit.php?id=" . $pagecontent['id'] . "' style='font-size: smaller;'>Uppdatera sidan</a>" : null;
$author = $pagecontent['name'] ? "<p style='font-size: smaller;'>Av" . $pagecontent['name'] . ". </p>" : null;
$leaf['title'] = $pagecontent['title'];
//$leaf['debug'] = $cpage->getDBDump();

// Do it and store it all in variables in the Leaf container
$leaf['main'] = <<<EOD
        <h1>{$leaf['title']}</h1>
        <aside id="report">
	{$aside}
	<hr style="border: 1px dashed #555;">
	</aside>
        <article>
			{$pagecontent['data']}
			<footer>
				{$author}{$editLink}
			</footer>
		</article>
EOD;

// Finally leave it all to the rendering phase of Leaf
include(LEAF_THEME_PATH);