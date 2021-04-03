<?php

Flight::route("GET /playlists", function() {
    $search = Flight::query('search');
    $offset = Flight::query('offset', 0);
    $limit = Flight::query('limit', 25);

    Flight::json(Flight::playlistService()->search_playlists($search, $offset, $limit));
});

Flight::route("GET /playlists/@id", function($id) {
    Flight::json(Flight::playlistService()->get_playlist_by_id($id));
});

Flight::route("POST /playlists", function() {
    Flight::playlistService()->add_playlist(Flight::request()->data->getData());
});

Flight::route("PUT /playlists/@id", function($id) {
    $request = Flight::request();
    Flight::playlistService()->update_playlist($id, $request->data->getData());
});

?>