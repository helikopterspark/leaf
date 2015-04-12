<?php

/**
 * Class for handling page and blog content
 *
 */
class CContent {

    protected $db; // Database
    protected $id;
    protected $title;
    protected $slug;
    protected $url;
    protected $data;
    protected $type;
    protected $filter;
    protected $filterX;
    protected $published;
    protected $updated;
    protected $link;
    protected $categoryID;
    protected $categoryName;
    protected $textfilter;
    protected $acronym;
    protected $name;
    private $save = null;
    private $doDelete = null;
    private $output = null;
    private $userID = null;

    public function __construct($optionsDB) {
        $this->db = new CDatabase($optionsDB);
        $this->textfilter = new CTextFilter();
        $this->getParamsAndValidate();
    }

    /**
     * Get and validate $_POST and $_GET parameters
     *
     *
     */
    private function getParamsAndValidate() {

        // Get parameters 
        $this->id = isset($_POST['id']) ? strip_tags($_POST['id']) : (isset($_GET['id']) ? strip_tags($_GET['id']) : null);
        $this->title = isset($_POST['title']) ? $_POST['title'] : null;
        $this->slug = isset($_POST['slug']) ? strip_tags($_POST['slug']) : (isset($_GET['slug']) ? strip_tags($_GET['slug']) : null);
        $this->url = isset($_POST['url']) ? strip_tags($_POST['url']) : (isset($_GET['url']) ? strip_tags($_GET['url']) : null);
        $this->data = isset($_POST['data']) ? $_POST['data'] : array();
        $this->type = isset($_POST['type']) ? strip_tags($_POST['type']) : array();
        $this->categoryID = isset($_POST['categoryID']) ? strip_tags($_POST['categoryID']) : null;
        $this->published = isset($_POST['published']) ? strip_tags($_POST['published']) : array();
        $this->updated = isset($_POST['updated']) ? strip_tags($_POST['updated']) : array();
        // Build filter string
        for ($i = 0; $i < 5; $i++) {
            $this->filter .= isset($_POST['filter' . $i]) ? $_POST['filter' . $i] . ',' : null;
        }
        if ($this->filter) {
            $this->filter = mb_substr($this->filter, 0, -1); // Remove last comma
        } else {
            $this->filter = 'markdown'; // If empty, markdown will be default
        }

        $this->save = isset($_POST['save']) ? true : false;
        $this->doDelete = isset($_POST['doDelete']) ? true : false;
        $this->acronym = isset($_SESSION['user']) ? $_SESSION['user']->acronym : null;
        $this->userID = isset($_SESSION['user']) ? $_SESSION['user']->id : null;

        // Check that incoming parameters are valid
        if (isset($this->id)) {
            is_numeric($this->id) or die('Check: Id must be numeric.');
        }
    }

    /**
     * Get content from database, set properties or use returned result
     *
     * @param $sql, string with sql query
     * @param $params array with query parameters
     * @return $res array with query result
     */
    protected function getContent($sql, $params) {
        $res = $this->db->ExecuteSelectQueryAndFetchAll($sql, $params);
        if ($res) {
            foreach ($res as $value) {

                $value->CategoryID = htmlentities($value->CategoryID, null, 'UTF-8');
                $value->CategoryName = htmlentities($value->CategoryName, null, 'UTF-8');


                // Sanitize content before using it.
                $value->title = htmlentities($value->title, null, 'UTF-8');
                $value->data = htmlentities($value->data, null, 'UTF-8');

                $value->url = htmlentities($value->url, null, 'UTF-8');
                $value->slug = htmlentities($value->slug, null, 'UTF-8');
                $value->type = htmlentities($value->type, null, 'UTF-8');
                $value->filter = htmlentities($value->filter, null, 'UTF-8');
                $value->published = htmlentities($value->published, null, 'UTF-8');
                if ($value->updated) {
                    $value->updated = htmlentities($value->updated, null, 'UTF-8');
                }
                if (isset($value->name)) {
                    $value->name = htmlentities($value->name, null, 'UTF-8');
                }
                $value->link = $this->getUrlToContent($value);
            }

            $c = $res[0];

            $this->id = $c->id;
            $this->url = $c->url;
            $this->slug = $c->slug;
            $this->type = $c->type;
            $this->categoryID = $c->CategoryID;
            $this->categoryName = $c->CategoryName;
            $this->title = $c->title;
            $this->data = $c->data;
            $this->filter = $c->filter;
            $this->published = $c->published;
            $this->updated = $c->updated;
            if (isset($c->name)) {
                $this->name = $c->name;
            }
            $this->link = $this->getUrlToContent($c);
        }
        return $res;
    }

    /**
     * Save form data
     *
     */
    public function SaveEdit() {

        if (isset($this->acronym) && $this->save) {
            //$this->initDatabaseTable();
            $this->url = empty($this->url) ? null : $this->url;
            $this->slug = empty($this->slug) ? null : $this->slug;
            if (empty($this->slug)) {
                $this->slug = $this->slugify($this->title);
            }

            if ($this->id) {

                $sql = '
			UPDATE Content SET
			title   = ?,
			slug    = ?,
			url     = ?,
			data    = ?,
			type    = ?,
			filter  = ?,
			published = ?,
			updated = NOW()
			WHERE 
			id = ?
			';
                $params = array(
                    $this->title,
                    $this->slug,
                    $this->url,
                    $this->data,
                    $this->type,
                    $this->filter,
                    $this->published,
                    $this->id
                );
                $res = $this->db->ExecuteQuery($sql, $params);
                $sql = "UPDATE Post2Category SET idCategory = ? WHERE idPost = $this->id;";
                $params = array($this->categoryID);
                $res = $this->db->ExecuteQuery($sql, $params);
            } else {
                $sql = '
			INSERT INTO Content (slug, url, type, title, data, filter, Content_userId, published, created) VALUES (
				?, ?, ?, ?, ?, ?, ?, NOW(), NOW()
				);';
                $params = array(
                    $this->slug,
                    $this->url,
                    $this->type,
                    $this->title,
                    $this->data,
                    $this->filter,
                    $this->userID,
                );
                $res = $this->db->ExecuteQuery($sql, $params);
                $this->id = $this->db->LastInsertID(); // To fill the form when reloading after save.

                $sql = 'INSERT INTO Post2Category (idPost, idCategory) VALUES (?,?);';
                $params = array($this->id, $this->categoryID);
                $res = $this->db->ExecuteQuery($sql, $params);
            }

            if ($res) {
                $this->output = 'Informationen sparades.';
            } else {
                $this->output = 'Informationen sparades EJ.<br><pre>' . print_r($this->db->ErrorInfo(), 1) . '</pre>';
            }
        }
    }

    /**
     * Create a link to the content, based on its type.
     *
     * @param object $content to link to.
     * @return string with url to display content.
     */
    protected function getUrlToContent($content) {
        switch ($content->type) {
            case 'page': return "page.php?url={$content->url}";
                break;
            case 'post': return "blog.php?slug={$content->slug}";
                break;
            default: return null;
                break;
        }
    }

    /**
     * Create a slug of a string, to be used as url.
     *
     * @param string $str the string to format as slug.
     * @returns str the formatted slug. 
     */
    private function slugify($str) {
        $str = mb_strtolower(trim($str));
        $str = str_replace(array('å', 'ä', 'ö'), array('a', 'a', 'o'), $str);
        $str = preg_replace('/[^a-z0-9-]/', '-', $str);
        $str = trim(preg_replace('/-+/', '-', $str), '-');
        return $str;
    }

    private function initDatabaseTable() {
        $sql = "
		CREATE TABLE IF NOT EXISTS Content
		(
			id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
			slug CHAR(80) UNIQUE,
			url CHAR(80) UNIQUE,

			type CHAR(80),
			title VARCHAR(80),
			data TEXT,
			filter CHAR(80),

			published DATETIME,
			created DATETIME,
			updated DATETIME,
			deleted DATETIME,
			Content_userId INT,
    		FOREIGN KEY (Content_userId) REFERENCES USER(id)

			) ENGINE INNODB CHARACTER SET utf8;";
        $this->db->ExecuteQuery($sql);
    }

    /**
     * Delete one post from database
     *
     * @param $id id of post to delete
     * @return bool, true if success else false
     */
    private function doDelete($id) {
        //$sql = 'DELETE FROM Content WHERE id = ? LIMIT 1;';
        $sql = 'UPDATE Content SET deleted = NOW() WHERE id = ?;';
        $params = array($id);
        if ($this->db->ExecuteQuery($sql, $params)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * List database content
     *
     * @return $list html list
     */
    public function listDBContent() {
        $sql = 'SELECT *, (published <= NOW()) AS available FROM VContent WHERE deleted IS NULL;';
        $res = $this->db->ExecuteSelectQueryAndFetchAll($sql);

        $list = '<ul>';
        foreach ($res as $key => $value) {
            $list .= '<li>' . $value->type . ' (' . (!$value->available ? 'inte ' : null) . 'publicerad): '
                    . htmlentities($value->title, null, 'UTF-8') . ' (<a href="edit.php?id=' . $value->id
                    . '"">uppdatera</a>, <a href="delete.php?id=' . $value->id . '">radera</a>, <a href="' . $this->getUrlToContent($value) . '">visa</a>)';
            $list .= '</li>';
        }
        $list .= '</ul>';

        $sql = 'SELECT * FROM VContent WHERE deleted IS NOT NULL;';
        $res = $this->db->ExecuteSelectQueryAndFetchAll($sql);

        if ($res) {
            $list .= '<p>Raderade poster</p><ul>';
            foreach ($res as $key => $value) {
                $list .= '<li>' . $value->type . ' (raderad): '
                        . htmlentities($value->title, null, 'UTF-8');
                $list .= '</li>';
            }
            $list .= '</ul>';
        }

        return $list;
    }

    /**
     * Get page title
     *
     * @return $title string with page title
     */
    public function getTitle() {
        return $this->title;
    }

    /**
     * Show edit form with page or post data
     *
     * @return $html html-form with or without data
     */
    public function showEditForm() {

        if (!isset($this->acronym)) {
            $html = '<p>Check: Du måste vara inloggad för att kunna redigera.</p>';
            return $html;
        }
        if ($this->id) {
            $sql = 'SELECT * FROM VContent WHERE id = ?';
            $this->getContent($sql, array($this->id));
            $categories = $this->getCategories();
            $postIsSelected = "";
            $pageIsSelected = "";

            // check which filters are set         
            $setFilters = array(
                'bbcode' => null,
                'link' => null,
                'markdown' => null,
                'nl2br' => null,
                'shortcode' => null,
            );
            for ($i = 0; $i < 5; $i++) {
                if (strpos($this->filter, array_keys($setFilters)[$i]) !== false) {
                    $setFilters[array_keys($setFilters)[$i]] = 'checked';
                }
            }

            // Form with data
            $html = <<<EOD
			<form method=post>
				<fieldset>
					<legend>Uppdatera</legend>
					<input type=hidden name=id value='{$this->id}'/>
					<p><label>Titel:</label><br><input type='text' name='title' value='{$this->title}'/></p>
EOD;
            switch ($this->type) {
                case 'post':
                    $html .= "<p><label>Slug:</label><br><input type='text' name='slug' value='{$this->slug}'/></p>";
                    $postIsSelected = "selected";
                    break;
                case 'page':
                    $html .= "<p><label>Url:</label><br><input type='text' name='url' value='{$this->url}'/></p>";
                    $pageIsSelected = "selected";
                    break;
                default:
                    break;
            }

            $html .= <<<EOD
					<textarea name="data">{$this->data}</textarea>
					<p><label for="input1">Typ:</label><br>
						<select id='input1' name='type'>
							<option value='page' {$pageIsSelected}>page</option>
							<option value='post' {$postIsSelected}>post</option>
						</select></p>
					<p>{$categories}</p>
					<p><label for="filter">Textfilter:</label><br>
					<input type="checkbox" name=filter1 value="bbcode" {$setFilters['bbcode']}>bbcode
					<input type="checkbox" name=filter2 value="link" {$setFilters['link']}>klickbara länkar
					<input type="checkbox" name=filter3 value="markdown" {$setFilters['markdown']}>markdown
					<input type="checkbox" name=filter4 value="nl2br" {$setFilters['nl2br']}>nl2br
					<input type="checkbox" name=filter5 value="shortcode" {$setFilters['shortcode']}>shortcode
					</p>
					<p><label>Publiceringsdatum:</label><br><input type='text' name='published' value='{$this->published}'/></p>
					<p><input type='submit' name='save' value='Spara'/>
						<input type='reset' value='Återställ'/></p>
						<p><a href="{$this->link}">Visa</a></p>
						<p>{$this->output}</p>
					</fieldset>
				</form>
EOD;
        } else {
            // Empty form
            $categories = $this->getCategories();
            $html = <<<EOD
			<form method=post>
				<fieldset>
					<legend>Skapa ny post/sida</legend>
					<p><label>Titel:</label><br><input type='text' name='title'/></p>
					<p><label>Slug:</label><br><input type='text' name='slug'/></p>
					<p><label>Url:</label><br><input type='text' name='url'/></p>
					
					<textarea name="data"></textarea>
					<p><label for="input1">Typ:</label><br>
						<select id='input1' name='type'>
							<option value='page'>page</option>
							<option value='post' selected>post</option>
						</select></p>
					<p>{$categories}</p>
					<p><label for="filter">Textfilter:</label><br>
					<input type="checkbox" name=filter1 value="bbcode">bbcode
					<input type="checkbox" name=filter2 value="link">link
					<input type="checkbox" name=filter3 value="markdown" checked>markdown
					<input type="checkbox" name=filter4 value="nl2br">nl2br
					<input type="checkbox" name=filter5 value="shortcode">shortcode
					</p>
					<p><label>Publiceringsdatum:</label><br><input type='text' name='published'/></p>
					<p><input type='submit' name='save' value='Spara'/>
						<input type='reset' value='Rensa'/></p>
						<p><a href="{$this->link}">Visa</a></p>
						<p>{$this->output}</p>
					</fieldset>
				</form>
EOD;
        }
        return $html;
    }

    /**
     * Verify delete of content
     *
     */
    public function verifyDelete() {
        if (!isset($this->acronym)) {
            $html = '<p>Check: Du måste vara inloggad.</p>';
            return $html;
        }
        if (!$this->id) {
            $html = '<p>Inlägget saknas</p>';
        } elseif ($this->doDelete) {
            if ($this->doDelete($this->id)) {
                $html = '<p>Inlägget raderades</p>';
            } else {
                $html = '<p>Inlägget raderades EJ.</p>';
            }
        } else {
            $sql = 'SELECT * FROM VContent WHERE id = ?';
            $this->getContent($sql, array($this->id));
            $html = <<<EOD
			<form method=post>
			<fieldset>
			<legend>Bekräfta</legend>
			<p>Vill du radera inlägget {$this->title}, publicerad {$this->published}?</p>
			<p><input type='submit' name='doDelete' value='Radera'/></p>
			</fieldset>
			</form>
EOD;
        }
        return $html;
    }

    /**
     * Get acronym of logged in user
     *
     * @return $acronym string
     */
    protected function getAcronym() {
        return $this->acronym;
    }

    /**
     * Dump database info
     *
     * @return database info
     */
    public function getDBDump() {
        return $this->db->Dump();
    }

    /**
     * Get list of categories
     *
     * @return html list of category strings
     */
    private function getCategories() {
        $sql = 'SELECT * FROM Category;';
        $res = $this->db->ExecuteSelectQueryAndFetchAll($sql);

        $select = '<label for="input2">Kategori:</label><br>';
        $select .= "<select id='input2' name='categoryID'>";
        foreach ($res as $value) {
            $selected = "";
            $catID = $value->id;
            $catName = $value->name;
            if ($this->categoryID == $catID) {
                $selected = "selected";
            }

            $select .= "<option value='{$catID}' {$selected}>{$catName} ({$catID})</option>";
        }
        $select .= "</select>";

        return $select;
    }

    /**
     * Returns a list of links to all blogposts
     *
     * @param $type optional string, page or post. Unspecified gets all content
     * @param $format optional string, html returns an unordered list
     * @return $linklist as html unordered list or as array with link and title as strings (for building navbar menu)
     */
    public function getLinklist($type = null, $format = null) {
        $sql = "
		SELECT *
		FROM VContent
		WHERE
		type = '$type' AND
		published <= NOW() AND
		deleted IS NULL
		ORDER BY updated DESC
		;
		";
        if ($type === 'page') {
            $res = $this->getContent($sql, array($this->url));
        } else {
            $res = $this->getContent($sql, array($this->slug));
        }
        $linklist = null;
        if (isset($res[0])) {
            if ($format == 'html') {

                $linklist = '<ul>';
                foreach ($res as $c) {
                    $linklist .= '<li><a href="' . $c->link . '">' . $c->title . '</a></li>';
                }
                $linklist .= '</ul>';
            } else {
                $linklist = array();
                foreach ($res as $c) {
                    $linklist[] = array('link' => $c->link, 'title' => $c->title);
                }
            }
        }
        return $linklist;
    }

    /**
     * Get array for building navbar submenu
     *
     * @param $type optional string, page or post for sending into getLinkList().
     * @return $blogmenu array with arrays for navbar
     */
    public function getNavbarArray($type = null) {
        $list = $this->getLinklist($type);
        $menu = array();
        if ($list[0]) {
            foreach ($list as $menuitem) {
                $menu[$menuitem['title']] = array(
                    'text' => $menuitem['title'],
                    'url' => $menuitem['link'],
                    'title' => $menuitem['title']
                );
            }
        }

        return $menu;
    }

    /**
     * Reset and restore database
     *
     */
    public function resetRestoreDB() {
        if ($this->acronym) {

            // Restore the database to its original settings BTH server
            $sql = 'reset.sql';
            $mysql = '/usr/bin/mysql';
            $host = 'localhost';
            $login = DB_USER;
            $password = DB_PASSWORD;
            $reset = null;

            /*
              // Restore the database to its original settings local
              $sql = 'reset.sql';
              $mysql = '/Applications/XAMPP/xamppfiles/bin/mysql';
              $host = 'localhost';
              $login = DB_USER;
              $password = DB_PASSWORD;
              $reset = null;
             */

            if (isset($_POST['restore']) || isset($_GET['restore'])) {
                $cmd = "$mysql -h{$host} -u{$login} -p'{$password}' < $sql 2>&1";
                $res = exec($cmd);
                //$reset = "<p>Databasen är återställd via kommandot<br/><code>{$cmd}</code></p><p>{$res}</p>";
                $reset = "<p>Databasen är återställd.</p>";
            }
            $output = <<<EOD
    		<form method=post>
        <p><input type='submit' name='restore' value='Återställ databasen'/></p>
        <output>{$reset}</output>
        </form>
EOD;
            return $output;
        } else {
            return '<p>Check: Du måste vara inloggad.</p>';
        }
    }

}
