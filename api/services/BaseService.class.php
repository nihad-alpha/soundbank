<?php
require_once dirname(__FILE__)."/../dao/BaseDao.class.php";

class BaseService {
    
    protected $dao;

    public function __construct() {
        $this->dao = new BaseDao();
    }

    public function get_by_id($id) {
        if (empty($this->dao->get_by_id($id))) throw new Exception("It doesn't exist!");
        return $this->dao->get_by_id($id);
    }

    public function add($params) {
        return $this->dao->add($params);
    }

    public function update_by_id($id, $params) {
        $this->dao->update_by_id($id, $params);
    }

    public function search_by_name($search, $offset, $limit, $order) {
        return $this->dao->search_by_name($search, $offset, $limit, $order);
    }
}
?>