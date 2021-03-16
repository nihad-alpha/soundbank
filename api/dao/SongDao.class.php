<?php
class SongDao extends BaseDao {

    public function get_song_by_id($id) {
        return $this->query_unique("SELECT * FROM songs WHERE song_id = :id", ["id" => $id]);
    }

    public function get_songs_by_artist_id($id) {
        return $this->query("SELECT * FROM songs WHERE artist_id = :id", ["id" => $id]);
    }

    public function get_song_by_name($song_name) {
        return $this->query("SELECT * FROM songs WHERE song_name = :song_name", ["song_name" => $song_name]);
    }

    public function get_song_length_by_id($id) {
        return $this->query_unique("SELECT length FROM songs WHERE song_id = :id", ["id" => $id]);
    }

    public function get_album_id_of_song_id($id) {
        return $this->query("SELECT album_id FROM songs WHERE song_id = :id", ["id" => $id]);
    }

    public function add_song($song) {
        return $this->insert("songs", $song);
    }

    public function update_song($id, $song) {
        $this->update("songs", "song_id", $id, $song);
    }
}
?>