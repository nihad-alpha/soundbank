<?php
/**
 * @OA\Get( path="/albums", tags={"album"},
 *     @OA\Parameter(type="string", in="query", name="search", default=""),
 *     @OA\Parameter(type="integer", in="query", name="offset", default=0),
 *     @OA\Parameter(type="integer", in="query", name="limit", default=25),
 *     @OA\Response(response="200", description="List all albums")
 * )
 */
Flight::route("GET /albums", function() {
    $search = Flight::query('search');
    $offset = Flight::query('offset', 0);
    $limit = Flight::query('limit', 25);

    Flight::json(Flight::albumService()->get_albums($search, $offset, $limit));
});

/**
 * @OA\Get( path="/albums/id/{id}", tags={"album"},
 *     @OA\Parameter(type="integer", in="path", name="id"),
 *     @OA\Response(response="200", description="List all albums by id")
 * )
 */
Flight::route("GET /albums/id/@id", function($id) {
    Flight::json(Flight::albumService()->get_by_id($id));
});

/**
 * @OA\Get( path="/albums/name/{name}", tags={"album"},
 *     @OA\Parameter(type="integer", in="path", name="name"),
 *     @OA\Response(response="200", description="List albums by name")
 * )
 */
Flight::route("GET /albums/name/@album_name", function($album_name) {
    Flight::json(Flight::albumService()->get_by_name($album_name));
});

/**
 * @OA\Post(
 *     path="/albums", tags={"album"},
 *     @OA\Response(response="200", description="Add album")
 * )
 */
Flight::route("POST /albums", function() {
    $request = Flight::request();
    Flight::albumService()->add($request->data->getData());
});

/**
 * @OA\Put( path="/albums/id/{id}", tags={"album"},
 *     @OA\Parameter(type="integer", in="path", name="id"),
 *     @OA\Response(response="200", description="Update album by id")
 * )
 */
Flight::route("PUT /albums/id/@id", function($id) {
    $data = Flight::request()->data->getData();
    Flight::albumService()->update_by_id($id, $data);
    Flight::json(Flight::albumService()->get_by_id($id));
});
?>