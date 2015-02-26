<?php

/**
 * A hand of dice to roll, with graphical representation
 *
 */
class CDiceHand {

    /**
     * Properties
     *
     */
    private $dice;
    private $numDice;
    private $sumThrow;
    private $sumTotal;

    /**
     * Constructor
     *
     * @param int $numDice the number of dice in the hand, defaults to five dice.
     */
    public function __construct($numDice = 5) {
        $this->dice = array();
        for ($i = 0; $i < $numDice; $i++) {
            $this->dice[] = new CDiceImage();
        }
        $this->numDice = $numDice;
        $this->sumThrow = 0;
        $this->sumTotal = 0;
        $this->grandTotal = 0;
    }

    /**
     * Roll all dice in the hand
     *
     */
    public function Roll() {
        $this->sumThrow = 0;
        for ($i = 0; $i < $this->numDice; $i++) {
            $this->dice[$i]->RollOnce();
            $this->sumThrow += $this->dice[$i]->GetLast();
        }
    }

    /**
     * Get the sum of the last roll
     *
     * @return int as a sum of the last roll, or 0 if no roll has been made.
     */
    public function GetSumThrow() {
        return $this->sumThrow;
    }

    /**
     * Save to total sum
     *
     */
    public function SaveTotal() {
        $this->sumTotal += $this->sumThrow;
    }

    /**
     * Get total sum
     *
     * @return int as a sum of throws made since last reset
     */
    public function GetTotal() {
        return $this->sumTotal;
    }

    /**
     * Reset total sum
     *
     */
    public function ResetTotal() {
        $this->sumTotal = 0;
        $this->sumThrow = 0;
    }

    /**
     * Get the rolls as a series of images
     *
     * @return string as the html representation of the last roll.
     */
    public function GetRollsAsImageList() {
        $html = "<ul class='dice'>";
        foreach ($this->dice as $value) {
            $val = $value->GetLast();
            $html .= "<li class='dice-{$val}'></li>";
        }
        $html .= "</ul>";
        return $html;
    }
}