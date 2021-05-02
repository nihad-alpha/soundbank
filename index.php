<?php 

/* 
    TO DO:
    - implement swagger
    - implement emailing system
        - login authentication
        - JWT token
    - implement middleware
    - implement the GUI
    - deploy
*/

// Displays errors.
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Includes FlightPHP.
require_once "vendor/autoload.php";

// Includes Daos, Routes and Services
require_once dirname(__FILE__)."/api/dao/AccountDao.class.php";
require_once dirname(__FILE__)."/api/dao/AlbumDao.class.php";
require_once dirname(__FILE__)."/api/dao/BaseDao.class.php";
require_once dirname(__FILE__)."/api/routes/accounts.php";
require_once dirname(__FILE__)."/api/routes/albums.php";
require_once dirname(__FILE__)."/api/routes/songs.php";
require_once dirname(__FILE__)."/api/routes/playlists.php";
require_once dirname(__FILE__)."/api/routes/artists.php";
require_once dirname(__FILE__)."/api/services/AccountService.class.php";
require_once dirname(__FILE__)."/api/services/AlbumService.class.php";
require_once dirname(__FILE__)."/api/services/SongService.class.php";
require_once dirname(__FILE__)."/api/services/PlaylistService.class.php";
require_once dirname(__FILE__)."/api/services/ArtistService.class.php";

// Links DAO layer and Presentation Layer (at the moment this is not supposed to be here!)
Flight::register("accountDao", "AccountDao");
Flight::register("albumDao", "AlbumDao");
Flight::register("songDao", "SongDao");

// Links DAO layer and Business Logic Layer 
Flight::register("accountService", "AccountService");
Flight::register("albumService", "AlbumService");
Flight::register("songService", "SongService");
Flight::register("playlistService", "PlaylistService");
Flight::register("artistService", "ArtistService");

// Mapped a function which returns values from the query inside of the link.
Flight::map('query', function($name, $default_value = null) {
    $request = Flight::request();
    $query_params = @$request->query->getData()[$name];
    $query_params = $query_params ? $query_params : $default_value;
    return $query_params;
});

// Start FlightPHP framework.
Flight::start();
?>