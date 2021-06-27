<?php
// Displays errors.
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use Firebase\JWT\JWT;

require_once dirname(__FILE__)."/../dao/AccountDao.class.php";
require_once dirname(__FILE__)."/BaseService.class.php";
require_once dirname(__FILE__)."/../config.php";
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

        $account['password'] = password_hash($account['password'], PASSWORD_DEFAULT);
        // Append to the account object when the user was created, the exact moment.
        $account += ["created_at" => date(Config::DATE_FORMAT)];

        return parent::add($account);
    }

    public function forgot($account) {
        if (!isset($account['email'])) throw new Exception("Email is missing!");
        $account_from_db = $this->dao->get_by_email($account['email']);

        if (!isset($account_from_db['id'])) throw new Exception("Account does not exist!");

        // To prevent hacking attempts using DDoS, a token can't be generated until 5 minutes after the generation of the previous one.
        if (strtotime(date(Config::DATE_FORMAT)) - strtotime($account_from_db['token_created_at']) < 300) throw new Exception("Are you trying to DDoS me, dumbass? Please, wait for a few minutes to generate a new token.");

        $account_from_db = $this->dao->update_by_id($account_from_db['id'], ['token' => md5(random_bytes(16)), 'token_created_at' => date(Config::DATE_FORMAT)]); 

        $this->smtpClient->send_recovery_account_token($account_from_db);
    }

    public function reset($account) {

        if (!isset($account['token'])) throw new Exception("Token is missing!");
        if (!isset($account['password'])) throw new Exception("New password is missing!");

        $account_from_db = $this->dao->get_by_token($account['token']);

        // To prevent hackers stealing this token, it expires after 3 minutes.
        if (strtotime(date(Config::DATE_FORMAT)) - strtotime($account_from_db['token_created_at']) > 180) throw new Exception("Token has expired.");

        if (!isset($account_from_db['id'])) throw new Exception("Account does not exist!");

        //update password
        $account_from_db = $this->dao->update_by_id($account_from_db['id'], ['password' => password_hash($account['password'], PASSWORD_DEFAULT), 'token' => null]);
        return $account_from_db;
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
        if (!password_verify($account['password'], $password_from_db)) {
            throw new Exception("Password is incorrect!");
        }

        $jwt = JWT::encode(["id" => $account_from_db['id']], Config::JWT_SECRET);

        return ["token" => $jwt];
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
                "account_type" => "REGISTERED",
                "status" => "PENDING",
                "token" => md5(random_bytes(16)),
                "created_at" => date(Config::DATE_FORMAT)
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

        $this->dao->update_by_id($account["id"], ["status" => "ACTIVE", "token" => null]);   
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