<?php
// Displays errors.
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once dirname(__FILE__)."/../dao/AccountDao.class.php";
require_once dirname(__FILE__)."/BaseService.class.php";

class AccountService extends BaseService {

    public function __construct() {
        $this->dao = new AccountDao();
    }

    public function get_accounts($search, $offset, $limit, $order) {
        if ($search) {
            return $this->dao->search_by_name($search, $offset, $limit, $order);
        } else {
            return $this->dao->get_all($offset, $limit, $order);
        }
    }

    public function add($account) {
        if (!isset($account['username'])) throw new Exception("Username is missing!");
        if (!isset($account['password'])) throw new Exception("Password is missing!");
        if (!isset($account['email'])) throw new Exception("Email is missing!");

        return parent::add($account);
    }

    public function register($account) {
        if (!isset($account["email"])) throw new Exception("Email is missing!");
        if (!isset($account["username"])) throw new Exception("Username is missing!");
        if (!isset($account["password"])) throw new Exception("Password is missing!");

        try {
            $this->dao->beginTransaction();
            
            $new_account = parent::add([
                "email" => $account["email"],
                "username" => $account["username"],
                "password" => $account["password"],
                "account_type_id" => 2,
                "status" => "PENDING",
                "token" => md5(random_bytes(16))
            ]);   
            
            $this->dao->commit();
        } catch (\Exception $e) {
            $this->dao->rollBack();
            throw $e;
        }
        // TO DO: Send an email with a token inside to the account to confirm the account!
        return $new_account;
    }

    public function confirm($token) {
        $account = $this->dao->get_by_token($token);

        if (!isset($account["id"])) throw new Exception("Account not found!");

        $this->dao->update_by_id($account["id"], ["status" => "ACTIVE"]);   
        // TO DO: Send an email to the account that the account is confirmed!
    }

    public function get_by_username($username) {
        return $this->dao->get_by_username($username);
    }

    public function get_by_token($token) {
        return $this->dao->get_by_token($token);
    }

    public function get_by_email($email) {
        return $this->dao->get_by_email($email);
    }

    public function update_by_email($email, $params) {
        return $this->dao->update_by_email($email, $params);
    }

}
?>