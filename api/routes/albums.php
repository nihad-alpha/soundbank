<?php

Flight::route("GET /albums", function() {
    $search = Flight::query('search');
    $offset = Flight::query('offset', 0);
    $limit = Flight::query('limit', 25);

    Flight::json(Flight::albumService()->get_albums($search, $offset, $limit));
});

Flight::route("GET /albums/id/@id", function($id) {
    Flight::json(Flight::albumService()->get_by_id($id));
});

Flight::route("GET /albums/name/@album_name", function($album_name) {
    Flight::json(Flight::albumService()->get_by_name($album_name));
});

Flight::route("POST /albums", function() {
    $request = Flight::request();
    Flight::albumService()->add($request->data->getData());
});

Flight::route("PUT /albums/id/@id", function($id) {
    $data = Flight::request()->data->getData();
    Flight::albumService()->update_by_id($id, $data);
    Flight::json(Flight::albumService()->get_by_id($id));
});
?>