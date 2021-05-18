<?php
require_once dirname(__FILE__)."/../dao/SongDao.class.php";
require_once dirname(__FILE__)."/BaseService.class.php";
require_once dirname(__FILE__)."/../dao/ArtistDao.class.php";

class SongService extends BaseService{

    public function __construct() {
        $this->dao = new SongDao();
    }
    
    public function add($song) {
        if (!isset($song['name'])) throw new Exception("Song name is missing!");
        if (!isset($song['song_genre'])) throw new Exception("Song genre is missing!");
        if (!isset($song['artist_id'])) throw new Exception("Artist ID is missing!");

        $artistDao = new ArtistDao();  
        if (empty($artistDao->get_by_id($song['artist_id']))) throw new Exception("Artist does not exist!");

        return parent::add($song);
    }

    // Searching songs by name.
    public function get_songs($search, $offset, $limit, $order) {
        if ($search) {
            return $this->dao->search_by_name($search, $offset, $limit, $order);
        } else {
            return $this->dao->get_all($offset, $limit, $order);
        }
    }

}
?>