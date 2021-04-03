<?php
require_once dirname(__FILE__)."/../dao/ArtistDao.class.php";

class ArtistService {
    
    protected $dao;

    public function __construct() {
        $this->dao = new ArtistDao();
    }

    public function search_artists($search, $offset, $limit) {
        if ($search) {
            return $this->dao->search_artists($search, $offset, $limit);
        } else {
            return $this->dao->get_all_artists($offset, $limit);
        }
    }

    public function get_artist_by_id($id) {
        return $this->dao->get_artist_by_id($id);
    }

    public function get_artist_by_name($name) {
        return $this->dao->get_artist_by_name($name);
    }

    public function add_artist($params) {
        $this->dao->add_artist($params);
    }

    public function update_artist($id, $params) {
        $this->dao->update_artist($id, $params);
    }
} 
?>