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
require_once dirname(__FILE__)."/../vendor/autoload.php";

// Include routes:
require_once dirname(__FILE__)."/routes/accounts.php";
require_once dirname(__FILE__)."/routes/albums.php";
require_once dirname(__FILE__)."/routes/songs.php";
require_once dirname(__FILE__)."/routes/playlists.php";
require_once dirname(__FILE__)."/routes/artists.php";

// Include services:
require_once dirname(__FILE__)."/services/AccountService.class.php";
require_once dirname(__FILE__)."/services/AlbumService.class.php";
require_once dirname(__FILE__)."/services/SongService.class.php";
require_once dirname(__FILE__)."/services/PlaylistService.class.php";
require_once dirname(__FILE__)."/services/ArtistService.class.php";

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

// Swagger documentation:
Flight::route ("GET /swagger", function () {
    $openapi = @\OpenApi\scan(dirname(__FILE__)."/routes");
    header('Content-Type: application/json');
    echo $openapi->toJson();
});

Flight::route("GET /", function() {
    Flight::redirect("/docs");
});


// Start FlightPHP framework.
Flight::start();

?>