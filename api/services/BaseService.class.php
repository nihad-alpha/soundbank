<?php
require_once dirname(__FILE__)."/../dao/BaseDao.class.php";

class BaseService {
    protected $dao;
    public function __construct() {
        $this->dao = new BaseDao();
    }

    public function get_by_id($id) {
        return $this->dao->get_by_id($id);
    }

    public function add($params) {
        $this->dao->add($params);
    }

    public function update_by_id($id, $params) {
        $this->dao->update_by_id($id, $params);
    }
}
?>