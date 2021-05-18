<?php
/**
 * @OA\Get( path="/songs", tags={"song"},
 *     @OA\Parameter(type="string", in="query", name="search", default=null, description="Parameter that allows searching through songs."),
 *     @OA\Parameter(type="integer", in="query", name="offset", default=0, description="Parameter that sets the starting position from which we start fetching songs."),
 *     @OA\Parameter(type="integer", in="query", name="limit", default=25, description="Parameter that limits how many songs are fetched."),
 *     @OA\Parameter(type="string", in="query", name="order", default="-id", description="Parameter that defines order."),
 *     @OA\Response(response="200", description="Fetch all songs.")
 * )
 */
Flight::route("GET /songs", function() {
    $search = Flight::query('search');
    $offset = Flight::query('offset', 0);
    $limit = Flight::query('limit', 25);
    $order = Flight::query('order');

    Flight::json(Flight::songService()->get_songs($search, $offset, $limit, $order));
});

/**
 * @OA\Get( path="/songs/{id}", tags={"song"},
 *     @OA\Parameter(type="integer", in="path", name="id", default=0, description="ID of the song you want to fetch."),
 *     @OA\Response(response="200", description="Fetch a song by ID.")
 * )
 */
Flight::route("GET /songs/@id", function($id) {
    Flight::json(Flight::songService()->get_by_id($id));
});

/**
* @OA\Post(
*     path="/songs", 
*     tags={"song"},
*     @OA\RequestBody(
*         required=true,
*         @OA\MediaType(
*             mediaType="application/json",
*             @OA\Schema(
*                 @OA\Property(
*                     description="Name of the song",
*                     property="name",
*                     type="string",
*                     example = "SONG_NAME_EXAMPLE"
*                 ),
*                 @OA\Property(
*                     description="Genre of the album",
*                     property="song_genre",
*                     type="string",
*                     example = "SONG_GENRE_EXAMPLE"
*                 ),
*                 @OA\Property(
*                     description="ID of the artist of the song",
*                     property="artist_id",
*                     type="integer",
*                     example = 0
*                 )
*              )
*        )
*     ),
*     @OA\Response(response="200", description="Add a new song.")
* )
*/
Flight::route("POST /songs", function() {
    $request = Flight::request();
    Flight::songService()->add($request->data->getData());
});

/**
* @OA\Put( path="/songs/{id}", tags={"song"},
*     @OA\Parameter(type="integer", in="path", name="id", default=0, description="ID of the song you want to update."),
*     @OA\RequestBody(
*         required=true,
*         @OA\MediaType(
*             mediaType="application/json",
*             @OA\Schema(
*                 @OA\Property(
*                     description="Name of the song",
*                     property="name",
*                     type="string",
*                     example = "SONG_NAME_EXAMPLE"
*                 ),
*                 @OA\Property(
*                     description="Genre of the album",
*                     property="song_genre",
*                     type="string",
*                     example = "SONG_GENRE_EXAMPLE"
*                 ),
*                 @OA\Property(
*                     description="ID of the artist of the song",
*                     property="artist_id",
*                     type="integer",
*                     example = 0
*                 )
*              )
*        )
*     ),
*     @OA\Response(response="200", description="Update a song by ID.")
* )
*/
Flight::route("PUT /songs/@id", function($id) {
    $data = Flight::request()->data->getData();
    Flight::songService()->update_by_id($id, $data);
    Flight::json(Flight::songService()->get_by_id($id));
});
?>