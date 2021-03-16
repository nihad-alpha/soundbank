<?php
require_once dirname(__FILE__)."/BaseDao.class.php";

class AccountDao extends BaseDao {
    public function get_account_by_id($id) {
        return $this->query_unique("SELECT * FROM accounts WHERE account_id = :id", ["id" => $id]);
    }

    public function get_account_by_username($username) {
        return $this->query_unique("SELECT * FROM accounts WHERE username = :username", ["username" => $username]);
    }

    public function add_account($params) {
        return $this->insert("accounts", $params);
    }

    public function update_account($id, $params) {
        $this->update("accounts", "account_id", $id, $params);
    }
}

?>