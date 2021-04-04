<?php
require_once dirname(__FILE__)."/../dao/SongDao.class.php";
require_once dirname(__FILE__)."/BaseService.class.php";

class SongService extends BaseService{

    public function __construct() {
        $this->dao = new SongDao();
    }
    
    // Searching songs by name.
    public function search_songs($search, $offset, $limit) {
        if ($search) {
            return $this->dao->search_songs($search, $offset, $limit);
        } else {
            return $this->dao->get_all($offset, $limit);
        }
    }

}
?>