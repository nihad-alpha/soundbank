<?php
require_once dirname(__FILE__)."/../dao/AlbumDao.class.php";
require_once dirname(__FILE__)."/BaseService.class.php";
require_once dirname(__FILE__)."/../dao/ArtistDao.class.php";

class AlbumService extends BaseService {
    public function __construct() {
        $this->dao = new AlbumDao();
    }

    public function add($album) {
        if (!isset($album['name'])) throw new Exception("Album name is missing!");
        if (!isset($album['album_genre'])) throw new Exception("Album name is missing!");
        if (!isset($album['artist_id'])) throw new Exception("Artist is missing!");

        $artistDao = new ArtistDao();  
        if (empty($artistDao->get_by_id($album['artist_id']))) throw new Exception("Artist does not exist!");

        return parent::add($album);
    }

    public function get_albums($search, $offset, $limit) {
        if ($search) {
            return $this->dao->search_by_name($search, $offset, $limit);
        } else {
            return $this->dao->get_all($offset, $limit);
        }
    }

    public function get_by_id($id) {
        return $this->dao->get_by_id($id);
    }

    public function get_by_name($album_name) {
        return $this->dao->get_by_name($album_name);
    }
}
?>