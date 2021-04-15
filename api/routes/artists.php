<?php
Flight::route("GET /artists", function() {
    $search = Flight::query('search');
    $offset = Flight::query('offset', 0);
    $limit = Flight::query('limit', 25);

    Flight::json(Flight::artistService()->get_artists($search, $offset, $limit));
});

Flight::route("GET /artists/id/@id", function($id) {
    Flight::json(Flight::artistService()->get_by_id($id));
});

Flight::route("POST /artists", function() {
    $request = Flight::request();
    Flight::artistService()->add($request->data->getData());
});

Flight::route("PUT /artists/id/@id", function($id) {
    $request = Flight::request();
    Flight::artistService()->update_by_id($id, $request->data->getData());
    Flight::json(Flight::artistService()->get_by_id($id));
});
?>