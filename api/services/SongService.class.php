<?php
require_once dirname(__FILE__)."/../dao/SongDao.class.php";

class SongService {

    private $dao;

    public function __construct() {
        $this->dao = new SongDao();
    }
    
    public function search_songs($search, $offset, $limit) {
        return $this->dao->search_songs($search, $offset, $limit);
    }

    public function get_song_by_id($id) {
        return $this->dao->get_song_by_id($id);
    }

    public function add_song($params) {
        $this->dao->add_song($params);
    }

    public function update_song($id, $data) {
        return $this->dao->update_song($id, $data);
    }
}
?>