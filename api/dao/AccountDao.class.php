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
        $insert_query = "INSERT INTO accounts (username, password, account_type_id) VALUES (:username, :password, :account_type_id)";
        $this->connection->prepare($insert_query)->execute($params);
    }

    public function update_account($id, $account) {
        $this->update("accounts", "account_id", $id, $account);
    }
}

?>