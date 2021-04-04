<?php
require_once dirname(__FILE__)."/../dao/AlbumDao.class.php";
require_once dirname(__FILE__)."/BaseService.class.php";

class AlbumService extends BaseService {
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

    public function get_album_by_id($id) {
        return $this->dao->get_album_by_id($id);
    }
}
?>