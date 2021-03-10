<?php  
require_once dirname(__FILE__)."/BaseDao.class.php";

class AlbumDao extends BaseDao {
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

    public function add_album($params) {
        $insert_query = "INSERT INTO albums (album_name, account_id, album_genre, cover_art_path, upload_date, album_length) VALUES (:album_name, :account_id, :album_genre, :cover_art_path, :upload_date, :album_length)";
        $this->connection->prepare($insert_query)->execute($params);
    }

    public function update_album($id, $params) {
        $this->update("albums", "album_id", $id, $params);
    }
}

?>