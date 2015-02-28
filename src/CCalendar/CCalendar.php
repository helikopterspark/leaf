<?php
/**
* Class for showing a calendar
*
*/
class CCalendar {
	/**
	* Properties
	*
	*/
	private $year;
	private $month;
	private $monthName;
	private $p;
	/**
	* Constructor
	*
	*/
	public function __construct($month, $year) {
		$this->year = $year;
		$this->month = $month;
		$this->monthName = $this->GetSwedishMonthName($month);
	}

	public function GetMonthNameAndYear() {
		$html = '<img src="img/koenigsee/koenigsee-2.jpg" width="960" height="180" alt="Königsee"/>';
		$html .= '<h1>' . $this->monthName . ' ';
		$html .= $this->year . '</h1>';
		
		return $html;
	}

	/**
	* Step to next month
	*
	*/
	public function GotoPrev() {
		if ($this->month == 1) {
		 	$this->month = 12;
		 	$this->year--;
		 } else {
		 	$this->month--;
		 }
		$this->monthName = $this->GetSwedishMonthName($this->month);
	}

	/**
	* Step to previous month
	*
	*/
	public function GotoNext() {
		if ($this->month == 12) {
		 	$this->month = 1;
		 	$this->year++;
		 } else {
		 	$this->month++;
		 }
		$this->monthName = $this->GetSwedishMonthName($this->month);
	}

	/**
	* Get month name in Swedish
	*
	* @param int current month
	* @return string with Swedish month name
	*/
	private function GetSwedishMonthName($month) {
		$swNames = array(
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
		return $swNames[$month - 1];
	}
}