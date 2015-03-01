<?php
/**
* Class for showing a Swedish calendar
*
*/
class CCalendar {
	/**
	* Properties
	*
	*/
	private $year;
	private $month;
	private $monthHTML;
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

	/**
	* Show calendar for a given month
	*
	* @return string of html
	*/
	public function ShowCalendar() {
		$this->monthHTML = new CCalendarMonth($this->month, $this->year);

		if ($this->month == 12) {
			$next = $this->GetSwedishMonthName(1);
		} else {
			$next = $this->GetSwedishMonthName($this->month + 1);
		}
		if ($this->month == 1) {
			$prev = $this->GetSwedishMonthName(12);
		} else {
			$prev = $this->GetSwedishMonthName($this->month - 1);
		}
		$html = '<img src="img/koenigsee/koenigsee-2.jpg" width="960" height="180" alt="Königsee"/>';
		$html .= '<div style="height: 400px;"><h1>' . $this->monthName . ' ';
		$html .= $this->year . '</h1>';

		// Weekdays heading
        $html .= '<div class="headingweekdays">';
        $html .= '<div class="week">V</div>';
        for ($i = 1; $i < 8; $i++) { 
        	$html .='<div class="weekdays">';
        	if ($i == 7) {
        		$html .= '<div><span class="red">';
        		$html .= $this->GetSwedishDayName($i);
        		$html .= '</span></div>';
        	} else {
        		$html .= $this->GetSwedishDayName($i);
        	}
        	$html .='</div>';
        }
        $html .= '</div>';
		$html .= '<div>' . $this->monthHTML->GetMonthAsHTML() . '</div>';
		$html .= <<<EOD
		<div class="left">
        	<p><a href="calendar.php?p=prevM">&lt; {$prev}</a></p>
        </div>
		<div class="right">
			<p style="text-align: right;"><a href="calendar.php?p=nextM">{$next} ></a></p>
		</div>
		<div class="right">
			<p style="text-align: center;"><a href="calendar.php?p=reset">Innevarande månad</a></p>
		</div></div>
EOD;
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

	/**
	* Get day name in Swedish
	*
	* @param int current day
	* @return string with Swedish day name
	*/
	private function GetSwedishDayName($day) {
		$swNames = array(
			"Måndag",
			"Tisdag",
			"Onsdag",
			"Torsdag",
			"Fredag",
			"Lördag",
			"Söndag");
		return $swNames[$day - 1];
	}
}