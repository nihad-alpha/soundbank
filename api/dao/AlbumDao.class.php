<?php  
require_once dirname(__FILE__)."/BaseDao.class.php";

class AlbumDao extends BaseDao {

    public function __construct() {
        parent::__construct("albums");
    }

    // Getting an album by it's name.
    public function get_by_name($album_name) {
        return $this->query("SELECT * FROM albums WHERE album_name = :album_name", ["album_name" => $album_name]);
    }
}

?>