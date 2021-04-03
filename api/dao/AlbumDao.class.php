<?php  
require_once dirname(__FILE__)."/BaseDao.class.php";

class AlbumDao extends BaseDao {

    public function __construct() {
        parent::__construct("albums");
    }

    // Searching albums by name.
    public function search_albums($search, $offset, $limit) {
        return $this->query("SELECT * FROM albums 
                             WHERE LOWER(album_name) LIKE CONCAT('%', :album_name, '%') 
                             LIMIT ${limit} OFFSET ${offset}", ["album_name" => strtolower($search)]);
    }

    // Getting all albums using offset and limit.
    public function get_all_albums($offset = 0, $limit = 10) {
        return $this->get_all($offset, $limit);
    }

    // Getting an album by an id.
    public function get_album_by_id($id) {
        return $this->query_unique("SELECT * FROM albums WHERE album_id = :id", ["id" => $id]);
    }

    // Getting an album by it's name.
    public function get_album_by_name($album_name) {
        return $this->query("SELECT * FROM albums WHERE album_name = :album_name", ["album_name" => $album_name]);
    }

    // Adding albums into the database.
    public function add_album($album) {
        $this->insert("albums", $album);
    }

    // Updating albums in the database.
    public function update_album($id, $album) {
        return $this->update("albums", "album_id", $id, $album);
    }
}

?>