<?php
require_once dirname(__FILE__)."/../dao/AlbumDao.class.php";

class AlbumService {
    private $dao;

    public function __construct() {
        $this->dao = new AlbumDao();
    }

    public function search_albums($search, $offset, $limit) {
        if ($search) {
            return $this->dao->search_albums($search, $offset, $limit);
        } else {
            return $this->dao->get_all_albums($offset, $limit);
        }
    }

    public function get_all_albums($offset, $limit) {
        return $this->dao->get_all_albums($offset, $limit);
    }

    public function get_album_by_id($id) {
        return $this->dao->get_album_by_id($id);
    }

    public function add_album($params) {
        $this->dao->add_album($params);
    }

    public function update_album($id, $data) {
        return $this->dao->update_album($id, $data);
    }
}
?>