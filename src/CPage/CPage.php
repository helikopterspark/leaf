<?php
/**
* Class for showing a page
*
*/
class CPage extends CContent {
	/**
	 * Properties
	 *
	 */
	private $emptypage = array('title' => 'Exempelsida',
				'data' => '<p>Det här är en exempelsida.</p>',
				'link' => null,
				'name' => null,
				'acronym' => null);

	/**
	 * Constructor
	 *
	 */
	public function __construct($optionsDB) {
		parent::__construct($optionsDB);
	}

	/**
	 * Get page content as array
	 *
	 * @return array with content
	 */
	public function getPageContent() {
		if ($this->url) {
			// Get content
			$sql = "
			SELECT *
			FROM VContent
			WHERE
			  type = 'page' AND
			  url = ? AND
			  published <= NOW(); AND
			  deleted IS NULL;
			";
			$res = $this->getContent($sql, array($this->url));

			if ($res[0]) {
				$c = $res[0];
				// Filter content before using it.
				$c->data = $this->textfilter->doFilter($c->data, "{$c->filter},purify,typography");

				return array('id' => $c->id,
						'title' => $c->title,
						'data' => $c->data,
						'link' => $c->link,
						'name' => $c->UserName,
					'acronym' => $this->acronym);
			} else {
				return $this->emptypage;
			}
		} else {
			return $this->emptypage;
		}
	}
}