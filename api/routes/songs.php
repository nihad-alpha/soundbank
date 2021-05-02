<?php
/**
 * @OA\Get( path="/songs", tags={"song"},
 *     @OA\Parameter(type="string", in="query", name="search", default=""),
 *     @OA\Parameter(type="integer", in="query", name="offset", default=0),
 *     @OA\Parameter(type="integer", in="query", name="limit", default=25),
 *     @OA\Response(response="200", description="List all songs")
 * )
 */
Flight::route("GET /songs", function() {
    $search = Flight::query('search');
    $offset = Flight::query('offset', 0);
    $limit = Flight::query('limit', 25);

    Flight::json(Flight::songService()->get_songs($search, $offset, $limit));
});

/**
 * @OA\Get( path="/songs/id/{id}", tags={"song"},
 *     @OA\Parameter(type="integer", in="path", name="id"),
 *     @OA\Response(response="200", description="List all songs by id")
 * )
 */
Flight::route("GET /songs/id/@id", function($id) {
    Flight::json(Flight::songService()->get_by_id($id));
});

/**
 * @OA\Post(
 *     path="/songs", tags={"song"},
 *     @OA\Response(response="200", description="Add song")
 * )
 */
Flight::route("POST /songs", function() {
    $request = Flight::request();
    Flight::songService()->add($request->data->getData());
});

/**
 * @OA\Put( path="/songs/id/{id}", tags={"song"},
 *     @OA\Parameter(type="integer", in="path", name="id"),
 *     @OA\Response(response="200", description="Update song by id")
 * )
 */
Flight::route("PUT /songs/id/@id", function($id) {
    $data = Flight::request()->data->getData();
    Flight::songService()->update_by_id($id, $data);
    Flight::json(Flight::songService()->get_by_id($id));
});
?>