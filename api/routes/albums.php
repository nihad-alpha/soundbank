<?php
require_once dirname(__FILE__)."/../dao/AlbumDao.class.php";

// Method for searching albums by name.
Flight::route("GET /albums", function() {
    $search = Flight::query('search');
    $offset = Flight::query('offset', 0);
    $limit = Flight::query('limit', 25);

    Flight::json(Flight::albumService()->search_albums($search, $offset, $limit));
});

// Getting albums by id from the database.
Flight::route("GET /albums/@id", function($id) {
    Flight::json(Flight::albumService()->get_album_by_id($id));
});

// Inserting new albums into the database.
Flight::route("POST /albums", function() {
    $request = Flight::request();
    Flight::albumService()->add_album($request->data->getData());
});

// Updating existing albums in the database.
Flight::route("PUT /albums/@id", function($id) {
    $data = Flight::request()->data->getData();
    Flight::albumService()->update_album($id, $data);
    Flight::json(Flight::albumService()->get_album_by_id($id));
});
?>