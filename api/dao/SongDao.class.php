<?php
class SongDao extends BaseDao {

    public function __construct() {
        parent::__construct("songs");
    }

    // Searching for songs by name.
    public function search_songs($search, $offset, $limit) {
        return $this->query("SELECT * FROM songs 
                             WHERE LOWER(song_name) LIKE CONCAT('%', :song_name, '%') 
                             LIMIT ${limit} OFFSET ${offset}", ["song_name" => strtolower($search)]);
    }

    // Getting all songs from the database using offset and limit.
    public function get_all_songs($offset = 0, $limit = 10) {
        return $this->get_all($offset, $limit);
    }

    // Getting a song by an id.
    public function get_by_id($id) {
        return $this->query_unique("SELECT * FROM songs WHERE song_id = :id", ["id" => $id]);
    }

    // Getting a song by it's name.
    public function get_song_by_name($song_name) {
        return $this->query("SELECT * FROM songs WHERE song_name = :song_name", ["song_name" => $song_name]);
    }

    // Adding a song into the database.
    public function add($song) {
        $this->insert("songs", $song);
    }

    // Updating a song in the database.
    public function update_by_id($id, $song) {
        return parent::update("songs", "song_id", $id, $song);
    }
}
?>