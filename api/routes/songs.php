<?php
// Includes:
require_once dirname(__FILE__)."/../dao/SongDao.class.php";


Flight::route("GET /songs", function() {
    $search = Flight::query('search');
    $offset = Flight::query('offset', 0);
    $limit = Flight::query('limit', 25);

    Flight::json(Flight::songService()->search_songs($search, $offset, $limit));
});

Flight::route("GET /songs/@id", function($id) {
    Flight::json(Flight::songService()->get_song_by_id($id));
});

Flight::route("POST /songs", function() {
    $request = Flight::request();
    Flight::songService()->add_song($request->data->getData());
});

Flight::route("PUT /songs/@id", function($id) {
    $data = Flight::request()->data->getData();
    Flight::songService()->update_song($id, $data);
    Flight::json(Flight::songService()->get_song_by_id($id));
});
?>