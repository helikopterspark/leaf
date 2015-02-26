<?php

/**
 * Playround for dice game
 *
 */
class CDicePlayer {

    /**
     * Properties
     *
     */
    private $playerID;
    private $playerScore;
    private $isRobot;

    /**
     * Constructor
     *
     * @param int $id for player id, int $robot to set computer player
     */
    public function __construct($id, $robot) {
        $this->playerID = $id;
        $this->playerScore = 0;
        if ($robot) {
            $this->isRobot = TRUE;
        }
    }

    /**
     * Get player ID
     *
     * @return int as player ID
     */
    public function GetPlayerID() {
        return $this->playerID;
    }

    /**
     * Set player score
     *
     * @param int $score as the score to set
     */
    public function SetPlayerScore($score) {
        $this->playerScore = $score;
    }

    /**
     * Get player score
     *
     * @return int as player score
     */
    public function GetPlayerScore() {
        return $this->playerScore;
    }

    /**
     * Check whether player is set up as computer player
     *
     * @return int 0 or 1 to indicate human or computer player
     */
    public function IsRobot() {
        return $this->isRobot;
    }

}
