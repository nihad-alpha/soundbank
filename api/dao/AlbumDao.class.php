<?php  
require_once dirname(__FILE__)."/BaseDao.class.php";

class Album extends BaseDao {
    public function get_album_by_id($id) {
        return $this->query_unique("SELECT * FROM albums WHERE album_id = :id", ["id" => $id]);
    }

    public function get_album_by_name($album_name) {
        return $this->query("SELECT * FROM albums WHERE album_name = :album_name", ["album_name" => $album_name]);
    }

    public function get_albums_by_artist_id($id) {
        return $this->query("SELECT * FROM albums WHERE artist_id = :id", ["id" => $id]);
    }

    public function get_songs_by_album_id($id) {
        return $this->query("SELECT * FROM songs WHERE album_id = :id", ["id" => $id]);
    }
}

?>