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
	private $prevYear;
	private $prevMonth;
	private $nextYear;
	private $nextMonth;

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

		$this->GotoPrev();
		$this->GotoNext();
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

		// Build html
		$html = '<img src="img/calendarpics/' .$this->month. '.jpg" width="960" height="180" alt="Kalenderbild"/>';
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
			<p><a href="?year={$this->prevYear}&month={$this->prevMonth}">&lt; {$prev}</a></p>
        </div>
		<div class="right">
			<p style="text-align: right;"><a href="?year={$this->nextYear}&month={$this->nextMonth}">{$next} ></a></p>
		</div>
		<div class="right">
			<p style="text-align: center;"><a href="calendar.php">Innevarande månad</a></p>
		</div></div>
EOD;
		return $html;
	}

	/**
	* Step to next month
	*
	*/
	private function GotoPrev() {
		if ($this->month == 1) {
		 	$this->prevMonth = 12;
		 	$this->prevYear = $this->year - 1;
		 } else {
		 	$this->prevMonth = $this->month - 1;
		 	$this->prevYear = $this->year;
		 }
	}

	/**
	* Step to previous month
	*
	*/
	private function GotoNext() {
		if ($this->month == 12) {
		 	$this->nextMonth = 1;
		 	$this->nextYear = $this->year + 1;
		 } else {
		 	$this->nextMonth = $this->month + 1;
		 	$this->nextYear = $this->year;
		 }
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