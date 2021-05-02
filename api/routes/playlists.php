<?php
/**
 * @OA\Get( path="/playlists", tags={"playlist"},
 *     @OA\Parameter(type="string", in="query", name="search", default=""),
 *     @OA\Parameter(type="integer", in="query", name="offset", default=0),
 *     @OA\Parameter(type="integer", in="query", name="limit", default=25),
 *     @OA\Response(response="200", description="List all playlists")
 * )
 */
Flight::route("GET /playlists", function() {
    $search = Flight::query('search');
    $offset = Flight::query('offset', 0);
    $limit = Flight::query('limit', 25);

    Flight::json(Flight::playlistService()->get_playlists($search, $offset, $limit));
});

/**
 * @OA\Get( path="/playlists/id/{id}", tags={"playlist"},
 *     @OA\Parameter(type="integer", in="path", name="id"),
 *     @OA\Response(response="200", description="List all playlists by id")
 * )
 */
Flight::route("GET /playlists/id/@id", function($id) {
    Flight::json(Flight::playlistService()->get_by_id($id));
});

/**
 * @OA\Post(
 *     path="/playlists", tags={"playlist"},
 *     @OA\Response(response="200", description="Add artist")
 * )
 */
Flight::route("POST /playlists", function() {
    Flight::playlistService()->add(Flight::request()->data->getData());
});

/**
 * @OA\Put( path="/playlists/id/{id}", tags={"playlist"},
 *     @OA\Parameter(type="integer", in="path", name="id"),
 *     @OA\Response(response="200", description="Update playlist by id")
 * )
 */
Flight::route("PUT /playlists/id/@id", function($id) {
    $request = Flight::request();
    Flight::playlistService()->update_by_id($id, $request->data->getData());
    Flight::json(Flight::playlistService()->get_by_id($id));
});

?>