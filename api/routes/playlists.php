<?php
/**
     * @OA\Get( path="/playlists", tags={"playlist"},
     *     @OA\Parameter(type="string", in="query", name="search", default=null, description="Parameter that allows searching through playlists."),
     *     @OA\Parameter(type="integer", in="query", name="offset", default=0, description="Parameter that sets the starting position from which we start fetching playlists."),
     *     @OA\Parameter(type="integer", in="query", name="limit", default=25, description="Parameter that limits how many playlists are fetched."),
     *     @OA\Parameter(type="string", in="query", name="order", default="-id", description="Parameter that defines order."),
     *     @OA\Response(response="200", description="Fetch all playlists.")
     * )
 */
Flight::route("GET /playlists", function() {
    $search = Flight::query('search');
    $offset = Flight::query('offset', 0);
    $limit = Flight::query('limit', 25);
    $order = Flight::query('order');

    Flight::json(Flight::playlistService()->get_playlists($search, $offset, $limit, $order));
});

/**
 * @OA\Get( path="/playlists/{id}", tags={"playlist"}, security={{"ApiKeyAuth": {}}},
 *     @OA\Parameter(type="integer", in="path", name="id", default=0, description="ID of the playlist you want to fetch."),
 *     @OA\Response(response="200", description="Fetch a playlist by ID.")
 * )
 */
Flight::route("GET /playlists/@id", function($id) {
    Flight::json(Flight::playlistService()->get_by_id($id));
});

/**
    * @OA\Post(
    *     path="/playlists", 
    *     tags={"playlist"},
    *     security={{"ApiKeyAuth": {}}},
    *     @OA\RequestBody(
    *         required=true,
    *         @OA\MediaType(
    *             mediaType="application/json",
    *             @OA\Schema(
    *                 @OA\Property(
    *                     description="Name of the playlist",
    *                     property="name",
    *                     type="string",
    *                     example = "PLAYLIST_NAME_EXAMPLE"
    *                 ),
    *                 @OA\Property(
    *                     description="Creator account id",
    *                     property="account_id",
    *                     type="integer",
    *                     example = 0
    *                 )
    *              )
    *        )
    *     ),
    *     @OA\Response(response="200", description="Add album")
    * )
*/
Flight::route("POST /playlists", function() {
    Flight::playlistService()->add(Flight::request()->data->getData());
});

/**
    * @OA\Put( path="/playlists/{id}", tags={"playlist"}, security={{"ApiKeyAuth": {}}},
    *     @OA\Parameter(type="integer", in="path", name="id", default=0, description="ID of the playlist you want to update."),
    *     @OA\RequestBody(
    *         required=true,
    *         @OA\MediaType(
    *             mediaType="application/json",
    *             @OA\Schema(
    *                 @OA\Property(
    *                     description="Name of the playlist",
    *                     property="name",
    *                     type="string",
    *                     example = "PLAYLIST_NAME_EXAMPLE"
    *                 ),
    *                 @OA\Property(
    *                     description="Creator account id",
    *                     property="account_id",
    *                     type="integer",
    *                     example = 0
    *                 )
    *              )
    *        )
    *     ),
    *     @OA\Response(response="200", description="Update a playlist by ID.")
    * )
 */
Flight::route("PUT /playlists/@id", function($id) {
    $request = Flight::request();
    Flight::playlistService()->update_by_id($id, $request->data->getData());
    Flight::json(Flight::playlistService()->get_by_id($id));
});

// CREATE A PLAYLIST
Flight::route("POST /playlist/create", function() {
});

?>