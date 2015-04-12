<?php

/**
 * Class for showing blog posts
 *
 */
class CBlog extends CContent {

    /**
     * Properties
     *
     */
    /*
    private $emptypost = array('title' => 'Tomt inlägg',
        'data' => '<p>Bloggposten saknas./p>',
        'link' => null,
        'acronym' => null);
	*/

    /**
     * Constructor
     *
     */
    public function __construct($optionsDB) {
        parent::__construct($optionsDB);
    }

    /**
     * Get blog content - querys the database and calls private method to build html
     *
     * @return $blogcontent as html
     */
    public function getBlogContent() {
        // Get content
        $slugSql = $this->slug ? 'slug = ?' : '1';
        $sql = "
		SELECT *
		FROM VContent
		WHERE
		type = 'post' AND
		$slugSql AND
		published <= NOW() AND
		deleted IS NULL
		ORDER BY updated DESC
		;
		";
        $res = $this->getContent($sql, array($this->slug));
        foreach ($res as $value) {
            $value->data = $this->textfilter->doFilter($value->data, "{$value->filter},purify,typography");
        }
        $blogcontent = $this->buildHTML($res);
        return $blogcontent;
    }

    /**
     * Build HTMl from blog query result
     *
     * @param $res query result
     * @return $html
     */
    private function buildHTML($res) {
    	$html = null;
        if (isset($res[0])) {
            foreach ($res as $c) {
                $editLink = $this->acronym ? "<a href='edit.php?id=" . $c->id . "'>Uppdatera inlägget</a>" : null;
                $html .= <<<EOD
                <div style="font-size: smaller; float:right;">{$editLink}</div>
		<h2 id="{$c->id}"><a href='{$c->link} '>{$c->title}</a></h2>
		<p style='font-size: smaller;'>Av {$c->UserName}.<br>Kategori: {$c->CategoryName}<br>Publicerad: {$c->published}. 
EOD;
                if (isset($c->updated)) {
                    $html .= '<span style="font-style: italic;">Uppdaterad: ' . $c->updated . '</span>';
                }
                $html .= '</p>' . $c->data . '<hr>';
            }
        } else {
            $html = '<p>Det finns inga bloggposter.</p>';
        }
        return $html;
    }
}
