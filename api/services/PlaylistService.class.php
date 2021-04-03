<?php
require_once dirname(__FILE__)."/../dao/PlaylistDao.class.php";

class PlaylistService {
    protected $dao;

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

    public function get_playlist_by_id($id) {
        return $this->dao->get_playlist_by_id($id);
    }

    public function get_all_playlists($offset = 0, $limit = 25) {
        return $this->dao->get_all_playlists($offset, $limit);
    }

    public function add_playlist($params) {
        $this->dao->add_playlist($params);
    }

    public function update_playlist($id, $params) {
        $this->dao->update_playlist($id, $params);
    }
}
?>