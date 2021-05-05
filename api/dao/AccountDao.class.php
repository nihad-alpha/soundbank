<?php
// Displays errors.
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once dirname(__FILE__)."/BaseDao.class.php";

class AccountDao extends BaseDao {

    public function __construct() {
        parent::__construct("accounts");
    }

    // Getting an account by email.
    public function get_by_email($email) {
        return $this->query_unique("SELECT * FROM accounts WHERE email = :email", ["email" => $email]);
    }

    // Getting an account by username.
    public function get_by_username($username) {
        return $this->query_unique("SELECT * FROM accounts WHERE username = :username", ["username" => $username]);
    }

    // Updating an account by an email.
    public function update_by_email($email, $params) {
        $this->update("accounts", "email", $email, $params);
    }
}

?>