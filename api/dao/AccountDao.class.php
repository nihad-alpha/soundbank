<?php
require_once dirname(__FILE__)."/BaseDao.class.php";

class AccountDao extends BaseDao {

    public function __construct() {
        parent::__construct("accounts");
    }
    
    public function get_all_accounts($offset = 0, $limit = 10) {
        return $this->get_all($offset, $limit);
    }

    public function get_accounts($search, $offset, $limit) {
        return $this->query("SELECT * FROM accounts 
                             WHERE LOWER(name) LIKE CONCAT('%', :name, '%') 
                             LIMIT ${limit} OFFSET ${offset}", ["name" => strtolower($search)]);
    }

    public function get_account_by_id($id) {
        return $this->query_unique("SELECT * FROM accounts WHERE account_id = :id", ["id" => $id]);
    }

    public function get_account_by_email($email) {
        return $this->query_unique("SELECT * FROM accounts WHERE email = :email", ["email" => $email]);
    }

    public function get_account_by_username($username) {
        return $this->query_unique("SELECT * FROM accounts WHERE username = :username", ["username" => $username]);
    }

    public function get_account_password_by_username($username) {
        return $this->query_unique("SELECT password FROM accounts WHERE username = :username", ["username" => $username]);
    }

    public function add_account($params) {
        $this->insert("accounts", $params);
    }

    public function update_account_by_id($id, $params) {
        $this->update("accounts", "account_id", $id, $params);
    }

    public function update_account_by_email($email, $params) {
        $this->update("accounts", "email", $email, $params);
    }
}

?>