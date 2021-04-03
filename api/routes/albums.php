<?php

Flight::route("GET /albums", function() {
    $search = Flight::query('search');
    $offset = Flight::query('offset', 0);
    $limit = Flight::query('limit', 25);

    Flight::json(Flight::albumService()->search_albums($search, $offset, $limit));
});

Flight::route("GET /albums/@id", function($id) {
    Flight::json(Flight::albumService()->get_album_by_id($id));
});

Flight::route("POST /albums", function() {
    $request = Flight::request();
    Flight::albumService()->add_album($request->data->getData());
});

Flight::route("PUT /albums/@id", function($id) {
    $data = Flight::request()->data->getData();
    Flight::albumService()->update_album($id, $data);
    Flight::json(Flight::albumService()->get_album_by_id($id));
});
?>