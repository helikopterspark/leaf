<?php

/**
 * Class for handling user authentication
 *
 */
class CUser {

    /**
     * Properties
     *
     */
    private $db;
    private $acronym = null;

    /**
     * Constructor
     *
     * @param array with DB access credentials
     */
    public function __construct($optionsDB) {
        if (!$this->IsAuthenticated()) {
            $this->db = new CDatabase($optionsDB);
        } else {
            $this->acronym = $_SESSION['user']->acronym;
        }
    }

    /**
     * Login
     *
     * @param string $user
     * @param string $password
     */
    public function Login($user, $password) {
        $sql = "SELECT acronym, name FROM USER WHERE acronym = ? AND password = md5(concat(?, salt))";
        $credentials = array($user, $password);
        $res = $this->db->ExecuteSelectQueryAndFetchAll($sql, $credentials);
        if (isset($res[0])) {
            $_SESSION['user'] = $res[0];
        }
    }

    /**
     * Logout
     *
     */
    public function Logout() {
        unset($_SESSION['user']);
    }

    /**
     * IsAuthenticated - check whether a user is logged in
     *
     * @return bool true or false (actually a value or null)
     */
    public function IsAuthenticated() {
        // Check if user is authenticated.
        $this->acronym = isset($_SESSION['user']) ? $_SESSION['user']->acronym : null;
        return $this->acronym;
    }

    /**
     * Get acronym
     *
     * @return string $acronym
     */
    public function GetAcronym() {
        return $this->acronym;
    }

    /**
     * Get name
     *
     * @return string $name
     */
    public function GetName() {
        return $_SESSION['user']->name;
    }

}
