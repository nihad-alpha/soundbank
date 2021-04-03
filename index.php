<?php 
// Displays errors.
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once "vendor/autoload.php";
require_once dirname(__FILE__)."/api/dao/AccountDao.class.php";
require_once dirname(__FILE__)."/api/dao/AlbumDao.class.php";
require_once dirname(__FILE__)."/api/dao/BaseDao.class.php";
require_once dirname(__FILE__)."/api/routes/accounts.php";
require_once dirname(__FILE__)."/api/routes/albums.php";
require_once dirname(__FILE__)."/api/routes/songs.php";

// Registers the AccountDao class into FlightPHP.
Flight::register("accountDao", "AccountDao");
Flight::register("albumDao", "AlbumDao");
Flight::register("songDao", "SongDao");

// Start FlightPHP framework.
Flight::start();
?>