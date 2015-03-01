<?php
/**
*
*
*/
class CCalendarMonth {
	private $month;
	private $year;
	private $date;
	private $firstWeek;
	private $lastWeek;
	private $firstDayOfWeek;
	private $lastDayOfWeek;

	/**
	* Constructor
	*
	*/
	public function __construct($month, $year) {
		$this->date = new DateTime();
		$this->date->setDate($year, $month, 01);
		$this->month = $month;
		$this->year = $year;
	}

	/**
	* Get month as HTML representation
	*
	* @return string as html
	*/
	public function GetMonthAsHTML() {
		$html = null;
		$day = null;
		$counter = 1;

		$this->firstWeek = date("W", strtotime($this->date->format('Y-m-01')));
		$this->lastWeek = date("W", strtotime($this->date->format('Y-m-t')));
		// Get all week numbers for the month
		$addWeeks = array();
		while ($counter < date("d", strtotime($this->date->format('Y-m-t')))) {
			$addWeeks[] = date("W", strtotime($this->date->format('Y-m-' . $counter. '')));
			$counter += 7;
		}
		$addWeeks[] = date("W", strtotime($this->date->format('Y-m-t')));
		$weekNos = array_unique($addWeeks);	// Remove duplicates
		$prevWeek = $weekNos[0];

		foreach ($weekNos as $week) {
			$tempYear = $this->year;
			$html .= '<div class="week">' . $week . '</div>';
			if ($prevWeek > $week && $this->month == 12) {
				$tempYear++;
			} else if ($week >= 52 && $this->month == 1) {
				$tempYear--;
			}
			for ($j = 1; $j <= 7; $j++) {
				
				$day = date('d', strtotime("$tempYear-W$week-$j"));

				if ($j == 7) {
					$html .= '<div class="holiday">' . (int)$day . '</div>';
				} else {
					$html .= '<div class="day">' . (int)$day . '</div>';
				}
			}
			$prevWeek = $week;
		}
		return $html;
	}
}