<?php
require_once dirname(__FILE__)."/../dao/SongDao.class.php";

// Method for searching songs by name.
Flight::route("GET /songs", function() {
    $search = Flight::query('search');
    $offset = Flight::query('offset', 0);
    $limit = Flight::query('limit', 25);

    Flight::json(Flight::songService()->search_songs($search, $offset, $limit));
});

// Getting songs by id from the database.
Flight::route("GET /songs/@id", function($id) {
    Flight::json(Flight::songService()->get_song_by_id($id));
});

// Inserting new songs into the database.
Flight::route("POST /songs", function() {
    $request = Flight::request();
    Flight::songService()->add_song($request->data->getData());
});

// Updating existing songs in the database.
Flight::route("PUT /songs/@id", function($id) {
    $data = Flight::request()->data->getData();
    Flight::songService()->update_song($id, $data);
    Flight::json(Flight::songService()->get_song_by_id($id));
});
?>