<?php
require_once dirname(__FILE__)."/BaseDao.class.php";

class AccountDao extends BaseDao {
    public function get_account_by_id($id) {
        return $this->query("SELECT * FROM accounts WHERE account_id = :id", ["id" => $id]);
    }

    public function get_account_by_username($username) {
        return $this->query("SELECT * FROM accounts WHERE username = :username", ["username" => $username]);
    }
}

?>