<?php
require_once dirname(__FILE__)."/../dao/ArtistDao.class.php";
require_once dirname(__FILE__)."/BaseService.class.php";

class ArtistService extends BaseService {

    public function __construct() {
        $this->dao = new ArtistDao();
    }

    public function search_artists($search, $offset, $limit) {
        if ($search) {
            return $this->dao->search_artists($search, $offset, $limit);
        } else {
            return $this->dao->get_all($offset, $limit);
        }
    }

    public function get_artist_by_name($name) {
        return $this->dao->get_artist_by_name($name);
    }
} 
?>