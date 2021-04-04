<?php
require_once dirname(__FILE__)."/BaseDao.class.php";

class ArtistDao extends BaseDao {

    public function __construct() {
        parent::__construct("artists");
    }

    // Searching artist by name.
    public function search_artists($search, $offset, $limit) {
        return $this->query("SELECT * FROM artists 
                             WHERE LOWER(artist_name) LIKE CONCAT('%', :artist_name, '%') 
                             LIMIT ${limit} OFFSET ${offset}", ["artist_name" => strtolower($search)]);
    }

    // Getting all artists using offset and limit.
    public function get_all_artists($offset = 0, $limit = 25) {
        return $this->get_all($offset, $limit);
    }

    // Getting artist by an id.
    public function get_by_id($id){
        return $this->query_unique("SELECT * FROM artists WHERE artist_id = :artist_id", ["artist_id" => $id]);
    }

    // Getting artist by name.
    public function get_by_name($name) {
        $this->query("SELECT * FROM artists WHERE artist_name = :artist_name", ["artist_name" => $name]);
    }

    // Adding artist into the database.
    public function add($params) {
        $this->insert("artists", $params);
    }

    // Updating existing artists in the database.
    public function update_by_id($id, $params) {
        $this->update("artists", "artist_id", $id, $params);
    } 
}
?>