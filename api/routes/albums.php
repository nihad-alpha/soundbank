<?php
require_once dirname(__FILE__)."/../dao/AlbumDao.class.php";

Flight::route("GET /albums", function() {
    Flight::json(Flight::albumDao()->get_all_albums());
});

Flight::route("GET /albums/@id", function($id) {
    Flight::json(Flight::albumDao()->get_album_by_id($id));
});

Flight::route("POST /albums", function() {
    $request = Flight::request();
    Flight::albumDao()->add_album($request->data->getData());
});

Flight::route("PUT /albums/@id", function($id) {
    $data = Flight::request()->data->getData();
    Flight::albumDao()->update_album($id, $data);
    Flight::json(Flight::albumDao()->get_album_by_id($id));
});
?>