<?php
require_once dirname(__FILE__)."/BaseDao.class.php";

class AccountDao extends BaseDao {

    public function __construct() {
        parent::__construct("accounts");
    }
    
    // Getting all accounts using offset and limit.
    public function get_all_accounts($offset = 0, $limit = 10) {
        return $this->get_all($offset, $limit);
    }

    // Searching accounts by name.
    public function search_accounts($search, $offset, $limit) {
        return $this->query("SELECT * FROM accounts 
                             WHERE LOWER(name) LIKE CONCAT('%', :name, '%') 
                             LIMIT ${limit} OFFSET ${offset}", ["name" => strtolower($search)]);
    }

    // Getting an account by id.
    public function get_account_by_id($id) {
        return $this->query_unique("SELECT * FROM accounts WHERE account_id = :id", ["id" => $id]);
    }

    // Getting an account by email.
    public function get_account_by_email($email) {
        return $this->query_unique("SELECT * FROM accounts WHERE email = :email", ["email" => $email]);
    }

    // Getting an account by username.
    public function get_account_by_username($username) {
        return $this->query_unique("SELECT * FROM accounts WHERE username = :username", ["username" => $username]);
    }

    // Adding accounts into the database.
    public function add_account($params) {
        $this->insert("accounts", $params);
    }

    // Updating an account by an id.
    public function update_account_by_id($id, $params) {
        $this->update("accounts", "account_id", $id, $params);
    }

    // Updating an account by an email.
    public function update_account_by_email($email, $params) {
        $this->update("accounts", "email", $email, $params);
    }
}

?>