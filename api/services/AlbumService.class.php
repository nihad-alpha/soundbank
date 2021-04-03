<?php
require_once dirname(__FILE__)."/../dao/AlbumDao.class.php";

class AlbumService {
    private $dao;

    public function __construct() {
        $this->dao = new AlbumDao();
    }

    
}
?>