<?php
/**
 * @OA\Get( path="/albums", tags={"album"},
 *     @OA\Parameter(type="string", in="query", name="search", default=null, description="Parameter that allows searching through albums."),
 *     @OA\Parameter(type="integer", in="query", name="offset", default=0, description="Parameter that sets the starting position from which we start fetching albums."),
 *     @OA\Parameter(type="integer", in="query", name="limit", default=25, description="Parameter that limits how many albums are fetched."),
 *     @OA\Parameter(type="string", in="query", name="order", default="-id", description="Parameter that defines order."),
 *     @OA\Response(response="200", description="Fetch all albums.")
 * )
 */
Flight::route("GET /albums", function() {
    $search = Flight::query('search');
    $offset = Flight::query('offset', 0);
    $limit = Flight::query('limit', 25);
    $order = Flight::query('order');

    Flight::json(Flight::albumService()->get_albums($search, $offset, $limit, $order));
});

/**
 * @OA\Get( path="/albums/{id}", tags={"album"},
 *     @OA\Parameter(type="integer", in="path", name="id", default=0, description="ID of album you want to fetch."),
 *     @OA\Response(response="200", description="Fetch an album by ID.")
 * )
 */
Flight::route("GET /albums/@id", function($id) {
    Flight::json(Flight::albumService()->get_by_id($id));
});

/**
* @OA\Post(
*     path="/albums", 
*     tags={"album"},
*     @OA\RequestBody(
*         required=true,
*         @OA\MediaType(
*             mediaType="application/json",
*             @OA\Schema(
*                 @OA\Property(
*                     description="Name of the album",
*                     property="name",
*                     type="string",
*                     example = "ALBUM_NAME_EXAMPLE"
*                 ),
*                 @OA\Property(
*                     description="Genre of the album",
*                     property="album_genre",
*                     type="string",
*                     example = "ALBUM_GENRE_EXAMPLE"
*                 ),
*                 @OA\Property(
*                     description="ID of the artist of the album",
*                     property="artist_id",
*                     type="integer",
*                     example = 0
*                 )
*              )
*        )
*     ),
*     @OA\Response(response="200", description="Add a new album.")
* )
*/
Flight::route("POST /albums", function() {
    $request = Flight::request();
    Flight::albumService()->add($request->data->getData());
});

/**
* @OA\Put( path="/albums/{id}", tags={"album"},
*     @OA\Parameter(type="integer", in="path", name="id", default = 0, description="ID of the album you want to update."),
*     @OA\RequestBody(
*         required=true,
*         @OA\MediaType(
*             mediaType="application/json",
*             @OA\Schema(
*                 @OA\Property(
*                     description="Name of the album",
*                     property="name",
*                     type="string",
*                     example = "ALBUM_NAME_EXAMPLE"
*                 ),
*                 @OA\Property(
*                     description="Genre of the album",
*                     property="album_genre",
*                     type="string",
*                     example = "ALBUM_GENRE_EXAMPLE"
*                 ),
*                 @OA\Property(
*                     description="ID of the artist of the album",
*                     property="artist_id",
*                     type="integer",
*                     example = 0
*                 ),
*                 @OA\Property(
*                     description="ID of the album",
*                     property="album_id",
*                     type="integer",
*                     example = NULL
*                 )
*              )
*        )
*     ),
*     @OA\Response(response="200", description="Update an album by ID.")
* )
*/
Flight::route("PUT /albums/@id", function($id) {
    $data = Flight::request()->data->getData();
    Flight::albumService()->update_by_id($id, $data);
    Flight::json(Flight::albumService()->get_by_id($id));
});
?>