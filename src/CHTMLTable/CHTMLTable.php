<?php

/**
 * Class for generating an HTML table with a database query result
 *
 */
class CHTMLTable {

    /**
     * Properties
     *
     */
    private $hits;
    private $page;
    private $max;

    /**
     * Constructor
     *
     */
    public function __construct() {
        $this->GetValidateGET();
    }

    /**
     * Return HTML table
     *
     * @param array with search result
     * @return string with search result as html table
     */
    public function GetHTMLTable($res) {
        $hitsPerPage = $this->getHitsPerPage(array(2, 4, 8), $this->hits);
        $navigatePage = $this->getPageNavigation($this->hits, $this->page, $res['max']);
        $tr = '<div><div class="rows">' . $res['rows'] . ' träffar. ' . $hitsPerPage . '</div><table>';
        // Put results into a HTML-table
        $tr .= "<tr><th>Rad</th><th>Id " . $this->orderby('id') . "</th><th>Bild</th><th>Titel " . $this->orderby('title') . "</th><th>År " . $this->orderby('year') . "</th><th>Genre</th></tr>";
        foreach ($res['qryres'] AS $key => $val) {
            $tr .= "<tr><td>{$key}</td><td>{$val->id}</td><td><img width='80' height='40' src='{$val->image}' alt='{$val->title}' /></td><td>{$val->title}</td><td>{$val->YEAR}</td><td>{$val->genre}</td></tr>";
        }
        $tr .= '</table><div class="pages">' . $navigatePage . '</div></div>';
        return $tr;
    }

    /**
     * Get GET variables and validate
     *
     */
    private function GetValidateGET() {
        // Get parameters
        $this->hits = isset($_GET['hits']) ? $_GET['hits'] : 8;
        $this->page = isset($_GET['page']) ? $_GET['page'] : 1;

        // Check that incoming parameters are valid
        is_numeric($this->hits) or die('Check: Hits must be numeric.');
        is_numeric($this->page) or die('Check: Page must be numeric.');
    }

    /**
     * Create links for hits per page.
     *
     * @param array $hits a list of hits-options to display.
     * @param array $current value.
     * @return string as a link to this page.
     */
    private function getHitsPerPage($hits, $current = null) {
        $nav = "Träffar per sida: ";
        foreach ($hits AS $val) {
            if ($current == $val) {
                $nav .= "$val ";
            } else {
                $nav .= "<a href='" . $this->getQueryString(array('hits' => $val)) . "'>$val</a> ";
            }
        }
        return $nav;
    }

    /**
     * Create navigation among pages.
     *
     * @param integer $hits per page.
     * @param integer $page current page.
     * @param integer $max number of pages. 
     * @param integer $min is the first page number, usually 0 or 1. 
     * @return string as a link to this page.
     */
    private function getPageNavigation($hits, $page, $max, $min = 1) {
        $nav = ($page != $min) ? "<a href='" . $this->getQueryString(array('page' => $min)) . "'>&lt;&lt;</a> " : '&lt;&lt; ';
        $nav .= ($page > $min) ? "<a href='" . $this->getQueryString(array('page' => ($page > $min ? $page - 1 : $min))) . "'>&lt;</a> " : '&lt; ';

        for ($i = $min; $i <= $max; $i++) {
            if ($page == $i) {
                $nav .= "$i ";
            } else {
                $nav .= "<a href='" . $this->getQueryString(array('page' => $i)) . "'>$i</a> ";
            }
        }

        $nav .= ($page < $max) ? "<a href='" . $this->getQueryString(array('page' => ($page < $max ? $page + 1 : $max))) . "'>&gt;</a> " : '&gt; ';
        $nav .= ($page != $max) ? "<a href='" . $this->getQueryString(array('page' => $max)) . "'>&gt;&gt;</a> " : '&gt;&gt; ';
        return $nav;
    }

    /**
     * Function to create links for sorting
     *
     * @param string $column the name of the database column to sort by
     * @return string with links to order by column.
     */
    private function orderby($column) {
        $nav = "<a href='" . $this->getQueryString(array('orderby' => $column, 'order' => 'asc')) . "'>&darr;</a>";
        $nav .= "<a href='" . $this->getQueryString(array('orderby' => $column, 'order' => 'desc')) . "'>&uarr;</a>";
        return "<span class='orderby'>" . $nav . "</span>";
    }

    /**
     * Use the current querystring as base, modify it according to $options and return the modified query string.
     *
     * @param array $options to set/change.
     * @param string $prepend this to the resulting query string
     * @return string with an updated query string.
     */
    private function getQueryString($options = array(), $prepend = '?') {
        // parse query string into array
        $query = array();
        parse_str($_SERVER['QUERY_STRING'], $query);

        // Modify the existing query string with new options
        $query = array_merge($query, $options);

        // Return the modified querystring
        return $prepend . htmlentities(http_build_query($query));
    }

}
