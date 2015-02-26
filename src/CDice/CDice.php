<?php

/**
 * A CDice class to play around with a dice.
 *
 */
class CDice {

    /**
     * Properties
     *
     */
    protected $rolls = array();
    private $faces;
    private $last;

    /**
     * Constructor
     *
     * @param int $faces the number of faces to use.
     */
    public function __construct($faces = 6) {
        $this->faces = $faces;
        //echo __METHOD__;
    }

    public function __destruct() {
        //echo __METHOD__;
    }

    /**
     * Get the number of faces
     *
     */
    public function GetFaces() {
        return $this->faces;
    }

    /**
     * Get the rolls as an array
     *
     */
    public function GetRollsAsArray() {
        return $this->rolls;
    }

    /**
     * Roll the dice
     *
     */
    public function Rolls($times) {
        $this->rolls = array();

        for ($i = 0; $i < $times; $i++) {
            $this->rolls[] = rand(1, $this->faces);
        }
    }

    /**
     * Roll once
     *
     */
    public function RollOnce() {
        $this->last = rand(1, $this->faces);
    }

    /**
     * Get last roll
     *
     */
    public function GetLast() {
        return $this->last;
    }

    /**
     * Get the total from the last roll(s).
     *
     */
    public function GetTotal() {
        return array_sum($this->rolls);
    }

    /**
     * Calculate average and return avg rounded to 2 decimals
     *
     */
    public function GetAverage() {
        return round((array_sum($this->rolls) / count($this->rolls)), 2);
    }

}
