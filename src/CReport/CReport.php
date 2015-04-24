<?php

/**
 * Class for showing reports
 *
 */
class CReport extends CContent {

    /**
     * Constructor
     *
     */
    public function __construct($optionsDB) {
        parent::__construct($optionsDB);
    }

    /**
     * Get report content - querys the database and calls private method to build html
     *
     * @return $reportcontent as html
     */
    public function getReportContent() {
        // Get content
        $slugSql = $this->slug ? 'slug = ?' : '1';
        $sql = "
		SELECT *
		FROM VContent
		WHERE
		type = 'report' AND
		$slugSql
		ORDER BY id ASC;";
        $res = $this->getContent($sql, array($this->slug));
        foreach ($res as $value) {
            $value->data = $this->textfilter->doFilter($value->data, "{$value->filter},purify,typography");
        }
        $reportcontent = $this->buildHTML($res);
        return $reportcontent;
    }

    /**
     * Build HTMl from report query result
     *
     * @param $res query result
     * @return $html
     */
    private function buildHTML($res) {
    	$html = null;
        if (isset($res[0])) {
            foreach ($res as $c) {
                $html .= <<<EOD
		<h2 id="{$c->id}">{$c->title}</a></h2>
        <div class='article_text'>
        {$c->data}
        </div>
        <div style="text-align:center;">
        <p><a href="#">Upp</a></p>
        </div><hr>
EOD;
            }
        } else {
            $html = '<p>Det finns inga rapporter.</p>';
        }
        return $html;
    }
}
