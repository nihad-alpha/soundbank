<?php
require_once dirname(__FILE__)."/../dao/PlaylistDao.class.php";
require_once dirname(__FILE__)."/BaseService.class.php";

class PlaylistService extends BaseService {

    public function __construct() {
        $this->dao = new PlaylistDao();
    }

    public function get_playlists($search, $offset, $limit) {
        if ($search) {
            return $this->dao->search_playlists($search, $offset, $limit);
        } else {
            return $this->dao->get_all($offset, $limit);
        }
    }
}
?>