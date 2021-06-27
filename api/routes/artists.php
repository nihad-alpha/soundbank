<?php
/**
     * @OA\Get( path="/artists", tags={"artist"},
     *     @OA\Parameter(type="string", in="query", name="search", default=null, description="Parameter that allows searching through artists."),
     *     @OA\Parameter(type="integer", in="query", name="offset", default=0, description="Parameter that sets the starting position from which we start fetching artists."),
     *     @OA\Parameter(type="integer", in="query", name="limit", default=25, description="Parameter that limits how many artists are fetched."),
     *     @OA\Parameter(type="string", in="query", name="order", default="-id", description="Parameter that defines order."),
     *     @OA\Response(response="200", description="Fetch all artists.")
     * )
 */
Flight::route("GET /artists", function() {
    $search = Flight::query('search');
    $offset = Flight::query('offset', 0);
    $limit = Flight::query('limit', 25);
    $order = Flight::query('order', '-id');

    Flight::json(Flight::artistService()->get_artists($search, $offset, $limit, $order));
});

/**
     * @OA\Get( path="/artists/{id}", tags={"artist"}, security={{"ApiKeyAuth": {}}},
     *     @OA\Parameter(type="integer", in="path", name="id", default=0, description="ID of an artist you want to fetch."),
     *     @OA\Response(response="200", description="Fetch an artist by ID.")
     * )
 */
Flight::route("GET /artists/@id", function($id) {
    Flight::json(Flight::artistService()->get_by_id($id));
});

/**
    * @OA\Post(
    *     path="/artists", 
    *     tags={"artist"},
    *     security={{"ApiKeyAuth": {}}},
    *     @OA\RequestBody(
    *         required=true,
    *         @OA\MediaType(
    *             mediaType="application/json",
    *             @OA\Schema(
    *                 @OA\Property(
    *                     description="Name of the artist",
    *                     property="name",
    *                     type="string",
    *                     example = "ARTIST_NAME_EXAMPLE"
    *                 )
    *              )
    *        )
    *     ),
    *     @OA\Response(response="200", description="Add a new artist.")
    * )
*/
Flight::route("POST /artists", function() {
    $request = Flight::request();
    Flight::artistService()->add($request->data->getData());
});

/**
    * @OA\Put( path="/artists/{id}", tags={"artist"}, security={{"ApiKeyAuth": {}}},
    *     @OA\Parameter(type="integer", in="path", name="id", default=0, description="ID of an artist you want to update."),
    *     @OA\RequestBody(
    *         required=true,
    *         @OA\MediaType(
    *             mediaType="application/json",
    *             @OA\Schema(
    *                 @OA\Property(
    *                     description="Name of the artist",
    *                     property="name",
    *                     type="string",
    *                     example = "ARTIST_NAME_EXAMPLE"
    *                 )
    *              )
    *        )
    *     ),
    *     @OA\Response(response="200", description="Update an artist by ID.")
    * )
*/
Flight::route("PUT /artists/@id", function($id) {
    $request = Flight::request();
    Flight::artistService()->update_by_id($id, $request->data->getData());
    Flight::json(Flight::artistService()->get_by_id($id));
});
?>