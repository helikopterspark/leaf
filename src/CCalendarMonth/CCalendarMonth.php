<?php
/**
*
*
*/
class CCalendarMonth {
	private $month;

	public function __construct($month) {
		$this->month = $this->GetSwedishMonthName($month);
	}

	public function GetMonthName() {
		return $this->month;
	}

	/**
	* Get month name in Swedish
	*
	* @param int current month
	* @return string with Swedish month name
	*/
	private function GetSwedishMonthName($month) {
		$swNames = array(
			"noll",
			"Januari",
			"Februari",
			"Mars",
			"April",
			"Maj",
			"Juni",
			"Juli",
			"Augusti",
			"September",
			"Oktober",
			"November",
			"December");
		return $swNames[$month];
	}
}