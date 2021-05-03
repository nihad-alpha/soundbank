<?php
require_once dirname(__FILE__)."/../dao/PlaylistDao.class.php";
require_once dirname(__FILE__)."/BaseService.class.php";
require_once dirname(__FILE__)."/../dao/AccountDao.class.php";

class PlaylistService extends BaseService {

    public function __construct() {
        $this->dao = new PlaylistDao();
    }

    public function add($playlist) {
        if (!isset($playlist['name'])) throw new Exception("Playlist name is missing!");
        if (!isset($playlist['account_id'])) throw new Exception("Creator account id is missing!");

        $accountDao = new AccountDao();
        if (empty($accountDao->get_by_id($playlist['account_id']))) throw new Exception("Account does not exist!");

        return parent::add($playlist);
    }

    public function get_playlists($search, $offset, $limit) {
        if ($search) {
            return $this->dao->search_playlists($search, $offset, $limit);
        } else {
            return $this->dao->get_all($offset, $limit);
        }
    }
}
?>