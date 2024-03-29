<?php
require_once dirname(__FILE__)."/../dao/ArtistDao.class.php";
require_once dirname(__FILE__)."/BaseService.class.php";

class ArtistService extends BaseService {

    public function __construct() {
        $this->dao = new ArtistDao();
    }

    public function add($artist) {
        if (!isset($artist['name'])) throw new Exception("Artist name is missing!");

        return parent::add($artist);
    }

    public function get_artists($search, $offset, $limit, $order) {
        if ($search) {
            return $this->dao->search_by_name($search, $offset, $limit, $order);
        } else {
            return $this->dao->get_all($offset, $limit, $order);
        }
    }

} 
?>