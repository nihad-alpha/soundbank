<?php
// Displays errors.
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once dirname(__FILE__)."/../dao/AccountDao.class.php";
require_once dirname(__FILE__)."/BaseService.class.php";

require_once dirname(__FILE__)."/../clients/SMTPClient.class.php";

class AccountService extends BaseService {

    private $smtpClient;
    public function __construct() {
        $this->dao = new AccountDao();
        $this->smtpClient = new SMTPClient();
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

    public function login($account) {
        // Check if the email and password have been entered.
        if (!isset($account['email'])) throw new Exception("Email missing!");
        if (!isset($account['password'])) throw new Exception("Password missing!");

        $account_from_db = $this->dao->get_by_email($account['email']);

        if (!isset($account_from_db['id'])) throw new Exception("That account does not exist!");

        // If the account hasn't activated their account by clicking on the confirmation link, his status will not be ACTIVE.
        if ($account_from_db['status'] != "ACTIVE") throw new Exception("Please, activate your account first. You should have recieved a confirmation email!");

        // We hashed the password using password_hash method from PHP
        // password_verify will now reverse the hash and check to see if our password is correct.
        
        $password_from_db = $account_from_db['password'];
        if (password_verify($account['password'], $password_from_db)) {
            Flight::json(["message" => "Password validated!"]);
        } else {
            throw new Exception("Password is incorrect!");
        }

        return $account_from_db;
    }

    public function register($account) {
        if (!isset($account["email"])) throw new Exception("Email is missing!");
        if (!isset($account["username"])) throw new Exception("Username is missing!");
        if (!isset($account["password"])) throw new Exception("Password is missing!");

        // Hashing the password for extra security! (We can unhash it by using passwory_verify() function in PHP)
        $hashed_password = password_hash($account['password'], PASSWORD_DEFAULT);

        try {
            $this->dao->beginTransaction();
            
            $new_account = [
                "email" => $account["email"],
                "username" => $account["username"],
                "password" => $hashed_password,
                "account_type_id" => 2,
                "status" => "PENDING",
                "token" => md5(random_bytes(16))
            ];   
            parent::add($new_account);

            $this->dao->commit();
        } catch (\Exception $e) {
            $this->dao->rollBack();
            throw $e;
        }
        
        // TO DO: Send an email with a token inside to the account to confirm the account!
        $this->smtpClient->send_register_account_token($new_account);
        
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