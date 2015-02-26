<?php

/**
 * Class for playing dice 100
 *
 */
class CPlayDice100 {

    /**
     * Private properties
     *
     */
    private $diceplay;
    private $hand;
    private $last;
    private $p;
    private $throwOrSaveMess;
    private $oneOrWinMess;
    private $player;
    private $players;
    private $defaultHumans;
    private $defaultRobots;
    private $throwSeries;
    private $diceround;
    private $nextplayer;
    private $gameover;

    /**
     * Constructor
     *
     */
    public function __construct() {
        $this->players = array();
        $this->defaultHumans = 1;
        $this->defaultRobots = 1;
        $this->diceround = 1;
        $this->last = 0;
        $this->throwSeries = array();
        $this->nextplayer = FALSE;
        $this->gameover = FALSE;
    }

    /**
     * Start or play game
     *
     * @return html page showing setup page or game board
     */
    public function PlayDice100() {
        // Initial setup - setup players or create player objects after setup
        if (!isset($_GET['setup']) && !$this->players) {
            $this->diceplay = $this->SetupPlayers();
            return $this->diceplay;
        } else if (!$this->players) {
            if (is_numeric($_GET['noOfPlayers']) && is_numeric($_GET['noOfRobots'])) {
                $counter = htmlentities($_GET['noOfPlayers']);
                for ($pl = 0; $pl < $_GET['noOfPlayers']; $pl++) {
                    $this->players[] = new CDicePlayer($pl + 1, 0);
                }
                for ($pl = 0; $pl < $_GET['noOfRobots']; $pl++) {
                    $this->players[] = new CDicePlayer($counter + 1, 1);
                    $counter++;
                }
            }
        }
        // Detect button press
        if (isset($_GET['p'])) {
            $this->p = $_GET['p'];
        }

        // Create new CDiceHand object if new game or next player
        if ($this->hand) {
            $this->player = $this->players[$this->diceround - 1];
        } else {
            $this->hand = new CDiceHand(1);
            $this->player = $this->players[$this->diceround - 1];
        }

        $this->RunGame();
        return $this->diceplay;
    }

    /**
     * Run Game
     *
     */
    private function RunGame() {
        // Detect button press and choose appropriate action
        switch ($this->p) {
            case 'Kasta':
                $this->ThrowDice();
                break;
            case 'Spara':
                $this->SaveRound();
                break;
            case 'Fortsätt':
                $this->GotoNextPlayer();
                break;
            case 'Börja om':
                $this->RestartGame();
                break;
            default:
                $this->ShowGameboard();
                break;
        }
    }

    /**
     * Throw dice
     *
     */
    private function ThrowDice() {
        $this->p = null; // Reset to keep state when switching pages
        $this->hand->Roll();
        $this->last = $this->hand->GetSumThrow(); // Set to keep state when switching pages
        if ($this->hand->GetSumThrow() == 1) {
            $this->hand->ResetTotal();
            $this->nextplayer = TRUE;
            $this->oneOrWinMess = '<p class="error">Spelare ' . $this->player->GetPlayerID() . ' slog en etta och förlorar ackumulerade poäng.</p>';
        } else {
            $this->hand->SaveTotal();
            $this->nextplayer = FALSE;
        }
        if ($this->player->GetPlayerScore() + $this->hand->GetTotal() >= 100) {
            $this->oneOrWinMess = '<p class="success">Spelare ' . $this->player->GetPlayerID() . ' har nått 100 poäng och vinner!</p>';
            $this->gameover = TRUE;
        }
        $this->ShowGameboard();
    }

    /**
     * Save round
     *
     */
    private function SaveRound() {
        $this->player->SetPlayerScore($this->hand->GetTotal() + $this->player->GetPlayerScore());
        $this->throwOrSaveMess = '<p class="info">Spelare ' . $this->player->GetPlayerID() . ' sparade.</p>';
        $this->nextplayer = TRUE;
        $this->hand->ResetTotal();
        $this->ShowGameboard();
    }

    /**
     * Go to next player
     *
     */
    private function GotoNextPlayer() {
    	$this->nextplayer = FALSE;
        $this->hand->ResetTotal();
        $this->throwSeries = null;
        $this->p = null; // Reset to keep state when switching pages
        $this->oneOrWinMess = null; // Reset to keep state when switching pages
        $this->last = 0; // Reset to keep state when switching pages
        if ($this->diceround < count($this->players)) {
            $this->diceround++;
        } else {
            $this->diceround = 1;
        }
        $this->player = $this->players[$this->diceround - 1];

        if ($this->player->IsRobot()) {
            $this->PlayRobotGame();
        }
        $this->ShowGameboard();
    }

    /**
     * Restart game - unsets game in $_SESSION variable and reloads page
     *
     */
    private function RestartGame() {
        unset($_SESSION['diceplay']);
        $host = $_SERVER['HTTP_HOST'];
        $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
        $extra = 'diceplay.php';
        header("Location: http://$host$uri/$extra");
        exit;
    }

    /**
     * Computer plays a round
     *
     */
    private function PlayRobotGame() {
    	// Go for at least 10 points
        while ($this->hand->GetTotal() <= 10 && $this->last != 1 && ($this->hand->GetTotal() + $this->player->GetPlayerScore()) < 100) {
            $this->ThrowDice();
            $this->throwSeries[] = $this->last;
        }
        // With 10 points, decide after each throw whether to stop or throw again
        while (rand(1,2) != 2 && $this->last != 1 && !$this->gameover) {
        	$this->ThrowDice();
        	$this->throwSeries[] = $this->last;
        }
        // Save and reload page
        if ($this->last != 1 && !$this->gameover) {
            $this->SaveRound();
            $this->p = 'Spara';
            $host = $_SERVER['HTTP_HOST'];
            $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
            $extra = 'diceplay.php';
            header("Location: http://$host$uri/$extra");
            exit;
        }
    }

    /**
     * Print the results
     *
     * @return $html as chunk of html to show current result
     */
    private function PrintResult() {
        $html = $this->hand->GetRollsAsImageList();
        $html .= '<p>Senaste kastet: ' . $this->last . '</p>';
        $html .= '<p>Den ackumulerade poängen är ' . $this->hand->GetTotal() . '</p>';
        $res = $this->player->GetPlayerScore() + $this->hand->GetTotal();
        if ($res < 100) {
            $html .= '<p>Spara nu för att säkra ' . $res . ' poäng</p>';
        } else {
            $html .= '<p>Total poäng blev ' . $res . '</p>';
        }
        if ($this->throwSeries) {
        	$html .= '<p>Datorspelarens kastserie: ';
        	foreach ($this->throwSeries as $value) {
        		$html .= $value . ' ';
        	}
        	$html .= '</p>';
        }
        return $html;
    }

    /**
     * Show leaderboard
     *
     * @return $html as chunk of html to show the current standing
     */
    private function ShowLeaderboard() {
        $html = <<<EOD
        <aside style="width: 50%; float: right;">
        <form method="get" action="?"><fieldset style="height:300px;"><legend>Resultattavla</legend>
EOD;
        if ($this->oneOrWinMess) {
            $html .= $this->oneOrWinMess;
        } else if ($this->throwOrSaveMess) {
            $html .= $this->throwOrSaveMess;
        } else {
            $html .= '<p class="info">Spelare ' . $this->diceround . ' kastar.</p>';
        }
        foreach ($this->players as $value) {
            $html .= '<p>Spelare ' . $value->GetPlayerID() . ': ' . $value->GetPlayerScore() . ' poäng</p>';
        }
        $html .= '<input type="submit" name="p" value="Börja om"></form></aside>';
        $this->throwOrSaveMess = null; // Reset to keep state when switching pages
        return $html;
    }

    /**
     * Show board
     *
     */
    private function ShowGameboard() {
        $this->diceplay = $this->ShowLeaderboard();
        $this->diceplay .= <<<EOD
        <div id="gameboard" style="width: 50%; height:450px;"><form method="get" action="?">
        <fieldset style="height:300px;"><legend>Spelare 
EOD;
        $this->diceplay .= $this->player->GetPlayerID() . '</legend>';

        if (!$this->nextplayer && !$this->gameover) {
            $this->diceplay .= '<p><input type="submit" name="p" value="Kasta">';
        } else {
            $this->diceplay .= '<p><input type="submit" name="p" value="Kasta" disabled>';
        }

        if ($this->p == 'Spara' || $this->hand->GetSumThrow() <= 1 || $this->gameover) {
            $this->diceplay .= '<input type="submit" name="p" value="Spara" disabled>';
        } else {
            $this->diceplay .= '<input type="submit" name="p" value="Spara" >';
        }

        if ($this->nextplayer && !$this->gameover) {
            $this->diceplay .= '<input type="submit" name="p" value="Fortsätt"/>';
        }
        $this->diceplay .= $this->PrintResult();

        $this->diceplay .= '</p></fieldset></form></div>';
    }

    /**
     * Setup players
     *
     * @return $html as chunk of html to show a form for setting no of players
     */
    private function SetupPlayers() {

        $humans = array(1 => "1", 2 => "2");
        $robots = array(0 => "0", 1 => "1", 2 => "2");

        $html = <<<EOD
    	<div style="width: 50%;">
    	<form method="get"><fieldset><legend>Ange antal spelare</legend>
    	<p><label for="input1">Människa:</label><br/><select id="input1" name="noOfPlayers">
EOD;

        foreach ($humans as $key => $value) {
            if ($key == $this->defaultHumans) {
                $html .= '<option selected="selected" value="' . $key . '">' . $value . '</option>';
            } else {
                $html .= '<option value="' . $key . '">' . $value . '</option>';
            }
        }

        $html .= <<<EOD
		</select></p><p><label for="input2">Dator:</label><br/><select id="input2" name="noOfRobots">
EOD;

        foreach ($robots as $key => $value) {
            if ($key == $this->defaultRobots) {
                $html .= '<option selected="selected" value="' . $key . '">' . $value . '</option>';
            } else {
                $html .= '<option value="' . $key . '">' . $value . '</option>';
            }
        }

        $html .= <<<EOD
        </select></p><p><input type="hidden" name="setup">
        <button onclick="form.submit();">Fortsätt</button></p>
        </fieldset></form></div>
EOD;
        return $html;
    }

}
