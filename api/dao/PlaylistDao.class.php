<?php
require_once dirname(__FILE__)."/BaseDao.class.php";

class PlaylistDAO extends BaseDao{

    public function __construct() {
        parent::__construct("playlists");
    }

    // Searching playlists by name.
    public function search_playlists($search, $offset, $limit) {
        return $this->query("SELECT * FROM playlists 
                             WHERE LOWER(name) LIKE CONCAT('%', :name, '%') 
                             LIMIT ${limit} OFFSET ${offset}", ["name" => strtolower($search)]);
    }

    // Get playlists by an id.
    public function get_by_id($id) {
        return $this->query("SELECT * FROM playlists WHERE playlist_id = :playlist_id", ["playlist_id" => $id]);
    }

    // Update existing playlists in the database.
    public function update_by_id($id, $params) {
        $this->update("playlists", "playlist_id", $id, $params);
    }
}

?>