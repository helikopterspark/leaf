<?php

/**
 * Class for showing a movie database search form.
 *
 */
class CMovieSearch {

    /**
     * Properties
     *
     */
    private $db; // database
    private $genre;
    private $hits;
    private $page;
    private $title;
    private $genres;
    private $year1;
    private $year2;
    private $order;
    private $orderby;

    /**
     * Constructor
     *
     * @param array with DB access credentials
     */
    public function __construct($optionsDB) {
        $this->GetValidateGET();
        $this->db = new CDatabase($optionsDB);
    }

    /**
     * Create search form
     *
     * @return string with html for search form
     */
    public function ShowSearchForm() {
        $this->genres = $this->GetGenres();
        $html = <<<EOD
		<form>
			<fieldset>
				<legend>Sök</legend>
				<input type=hidden name=genre value='{$this->genre}'/>
				<input type=hidden name=hits value='{$this->hits}'/>
				<input type=hidden name=page value='1'/>
				<p><label>Titel (delsträng, använd % som *): <input type='search' name='title' value='{$this->title}'/></label></p>
				<p><label>Välj genre:</label> {$this->genres}</p>
				<p><label>Skapad mellan åren: 
					<input type='text' name='year1' value='{$this->year1}'/></label>
					- 
					<label><input type='text' name='year2' value='{$this->year2}'/></label>

				</p>
				<p><input type='submit' name='submit' value='Sök'/></p>
				<p><a href='?'>Visa alla</a></p>
			</fieldset>
		</form>
EOD;
        return $html;
    }

    /**
     * Prepare SQL-query and return result
     *
     * @return array with search result
     */
    public function PreparePerformSQLquery() {
        // Prepare the query based on incoming arguments
        $sqlOrig = '
		SELECT 
		M.*,
		GROUP_CONCAT(G.name) AS genre
		FROM Movie AS M
		LEFT OUTER JOIN Movie2Genre AS M2G
		ON M.id = M2G.idMovie
		INNER JOIN Genre AS G
		ON M2G.idGenre = G.id
		';
        $where = null;
        $groupby = ' GROUP BY M.id';
        $limit = null;
        $sort = " ORDER BY $this->orderby $this->order";
        $params = array();

        // Select by title
        if ($this->title) {
            $where .= ' AND title LIKE ?';
            $params[] = $this->title;
        }

        // Select by year
        if ($this->year1) {
            $where .= ' AND year >= ?';
            $params[] = $this->year1;
        }
        if ($this->year2) {
            $where .= ' AND year <= ?';
            $params[] = $this->year2;
        }

        // Select by genre
        if ($this->genre) {
            $where .= ' AND G.name = ?';
            $params[] = $this->genre;
        }

        // Pagination
        if ($this->hits && $this->page) {
            $limit = " LIMIT $this->hits OFFSET " . (($this->page - 1) * $this->hits);
        }

        // Complete the sql statement
        $where = $where ? " WHERE 1 {$where}" : null;
        $sql = $sqlOrig . $where . $groupby . $sort . $limit;
        $res['qryres'] = $this->db->ExecuteSelectQueryAndFetchAll($sql, $params);


        // Get max pages for current query, for navigation
        $sql = "
		SELECT
		COUNT(id) AS rows
		FROM 
		(
			$sqlOrig $where $groupby
			) AS Movie
		";
        $resPage = $this->db->ExecuteSelectQueryAndFetchAll($sql, $params);
        $res['rows'] = $resPage[0]->rows;
        $res['max'] = ceil($res['rows'] / $this->hits);

        return $res;
    }

    /**
     * Get GET variables and validate
     *
     */
    private function GetValidateGET() {
        // Get parameters
        $this->genre = isset($_GET['genre']) ? $_GET['genre'] : null;
        $this->hits = isset($_GET['hits']) ? $_GET['hits'] : 8;
        $this->page = isset($_GET['page']) ? $_GET['page'] : 1;
        $this->title = isset($_GET['title']) ? $_GET['title'] : null;
        $this->year1 = isset($_GET['year1']) && !empty($_GET['year1']) ? $_GET['year1'] : null;
        $this->year2 = isset($_GET['year2']) && !empty($_GET['year2']) ? $_GET['year2'] : null;
        $this->order = isset($_GET['order']) ? strtolower($_GET['order']) : 'asc';
        $this->orderby = isset($_GET['orderby']) ? strtolower($_GET['orderby']) : 'id';

        // Check that incoming parameters are valid
        is_numeric($this->hits) or die('Check: Hits must be numeric.');
        is_numeric($this->page) or die('Check: Page must be numeric.');
        is_numeric($this->year1) || !isset($this->year1) or die('Check: Year must be numeric or not set.');
        is_numeric($this->year2) || !isset($this->year2) or die('Check: Year must be numeric or not set.');
    }

    /**
     * Get genres that are active
     *
     * @return string with genres as html links
     */
    private function GetGenres() {
        // Get all genres that are active
        $sql = '
		SELECT DISTINCT G.name
		FROM Genre AS G
		INNER JOIN Movie2Genre AS M2G
		ON G.id = M2G.idGenre
		ORDER BY G.name ASC';
        $res = $this->db->ExecuteSelectQueryAndFetchAll($sql);

        $genres = null;
        foreach ($res as $val) {
            if ($val->name == $this->genre) {
                $genres .= "$val->name ";
            } else {
                $genres .= "<a href='" . $this->getQueryString(array('genre' => $val->name)) . "'>{$val->name}</a> ";
            }
        }
        return $genres;
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
