<?php

/**
 * Class for getting all the weeks and days in a month
 *
 */
class CCalendarMonth {

    /**
     * Properties
     *
     */
    private $month;
    private $year;
    private $date;

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

        // Get all week numbers for the month
        $addWeeks = array();
        while ($counter < date("d", strtotime($this->date->format('Y-m-t')))) {
            $addWeeks[] = date("W", strtotime($this->date->format('Y-m-' . $counter . '')));
            $counter += 7;
        }
        $addWeeks[] = date("W", strtotime($this->date->format('Y-m-t')));
        $weekNos = array_unique($addWeeks); // Remove duplicates
        $prevWeek = $weekNos[0];

        // Render weeks with week numbers and days
        foreach ($weekNos as $week) {
            $tempYear = $this->year;
            $html .= '<div class="week">' . $week . '</div>';
            if ($prevWeek > $week && $this->month == 12) {
                $tempYear++;
            } else if ($week >= 52 && $this->month == 1) {
                $tempYear--;
            }
            for ($j = 1; $j <= 7; $j++) {
                $spancounter = 0;
                $day = date('d', strtotime("$tempYear-W$week-$j"));
                $notInMonth = date('n', strtotime("$tempYear-W$week-$j"));

                if ($day == date("j") && $this->month == date("n") && $this->year == date("Y") && $notInMonth == $this->month) {
                    $html .= '<div class="today">';
                } else {
                    $html .= '<div class="day">';
                }

                if ($notInMonth != $this->month) {
                    $html .= '<span class="outsidemonth">';
                    $spancounter++;
                }

                if ($j == 7 || $this->IsAHoliday($this->month, $day) && $notInMonth == $this->month) {
                    $html .= '<span class="holiday">';
                    $spancounter++;
                }
                if ($this->IsAHoliday($notInMonth, $day)) {
                    $html .= '<span class="holiday">';
                    $spancounter++;
                }
                $html .= (int) $day;
                // close span tags
                for ($k = 0; $k < $spancounter; $k++) {
                    $html.= '</span>';
                }
                $html .= '</div>';
            }
            $prevWeek = $week;
        }
        return $html;
    }

    /**
     *  Check holiday. The holidays that occur on the same date every year.
     *
     * @param $day as int, convert to string and compare
     *  @return string the holiday name or false.
     */
    private function IsAHoliday($month, $day) {
        $hol = (string) $month . '-' . (string) $day;
        switch ($hol) {
            case '1-01':
                return "Nyårsdagen";
            case '1-06':
                return "Trettondedag jul";
            case '5-01':
                return 'Första maj';
            case '6-06':
                return 'Sveriges nationaldag';
            case '12-25':
                return 'Juldagen';
            case '12-26':
                return 'Annandag jul';
        }
        return false;
    }

}
