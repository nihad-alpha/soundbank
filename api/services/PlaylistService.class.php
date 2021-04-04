<?php
require_once dirname(__FILE__)."/../dao/PlaylistDao.class.php";
require_once dirname(__FILE__)."/BaseService.class.php";

class PlaylistService extends BaseService {

    public function __construct() {
        $this->dao = new PlaylistDao();
    }

    public function search_playlists($search, $offset, $limit) {
        if ($search) {
            return $this->dao->search_playlists($search, $offset, $limit);
        } else {
            return $this->dao->get_all_playlists($offset, $limit);
        }
    }

    public function get_all_playlists($offset = 0, $limit = 25) {
        return $this->dao->get_all($offset, $limit);
    }
}
?>