<?php
require_once dirname(__FILE__)."/../dao/AccountDao.class.php";

class AccountService {

    private $dao;
    public function __construct() {
        $this->dao = new AccountDao();
    }

    public function search_accounts($search, $offset, $limit) {
        if ($search) {
            return $this->dao->search_accounts($search, $offset, $limit);
        } else {
            return $this->dao->get_all_accounts($offset, $limit);
        }
    }

    public function get_account_by_id($id) {
        return $this->dao->get_account_by_id($id);
    }

    public function get_account_by_username($username) {
        return $this->dao->get_account_by_username($username);
    }

    public function get_account_by_email($email) {
        return $this->dao->get_account_by_email($email);
    }

    public function add_account($params) {
        $this->dao->add_account($params);
    }

    public function update_account_by_id($id, $params) {
        $this->dao->update_account_by_id($id, $params);
    }

    public function update_account_by_email($email, $params) {
        return $this->dao->update_account_by_email($email, $params);
    }

}
?>