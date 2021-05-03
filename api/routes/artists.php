<?php
/**
 * @OA\Get( path="/artists", tags={"artist"},
 *     @OA\Parameter(type="string", in="query", name="search", default=""),
 *     @OA\Parameter(type="integer", in="query", name="offset", default=0),
 *     @OA\Parameter(type="integer", in="query", name="limit", default=25),
 *     @OA\Response(response="200", description="List all artists")
 * )
 */
Flight::route("GET /artists", function() {
    $search = Flight::query('search');
    $offset = Flight::query('offset', 0);
    $limit = Flight::query('limit', 25);

    Flight::json(Flight::artistService()->get_artists($search, $offset, $limit));
});

/**
 * @OA\Get( path="/artists/id/{id}", tags={"artist"},
 *     @OA\Parameter(type="integer", in="path", name="id"),
 *     @OA\Response(response="200", description="List all artists by id")
 * )
 */
Flight::route("GET /artists/id/@id", function($id) {
    Flight::json(Flight::artistService()->get_by_id($id));
});

/**
* @OA\Post(
*     path="/artists", 
*     tags={"artist"},
*     @OA\RequestBody(
*         required=true,
*         @OA\MediaType(
*             mediaType="application/json",
*             @OA\Schema(
*                 @OA\Property(
*                     description="Name of the artist",
*                     property="artist_name",
*                     type="string",
*                     example = "ARTIST_NAME_EXAMPLE"
*                 )
*              )
*        )
*     ),
*     @OA\Response(response="200", description="Add album")
* )
*/
Flight::route("POST /artists", function() {
    $request = Flight::request();
    Flight::artistService()->add($request->data->getData());
});

/**
 * @OA\Put( path="/artists/id/{id}", tags={"artist"},
 *     @OA\Parameter(type="integer", in="path", name="id"),
 *     @OA\Response(response="200", description="Update artist by id")
 * )
 */
Flight::route("PUT /artists/id/@id", function($id) {
    $request = Flight::request();
    Flight::artistService()->update_by_id($id, $request->data->getData());
    Flight::json(Flight::artistService()->get_by_id($id));
});
?>