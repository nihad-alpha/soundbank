<?php
require_once dirname(__FILE__)."/../dao/AccountDao.class.php";
require_once dirname(__FILE__)."/BaseService.class.php";

class AccountService extends BaseService {

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

    public function get_account_by_username($username) {
        return $this->dao->get_account_by_username($username);
    }

    public function get_account_by_email($email) {
        return $this->dao->get_account_by_email($email);
    }

    public function update_account_by_email($email, $params) {
        return $this->dao->update_account_by_email($email, $params);
    }

}
?>