<?php
// Displays errors.
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// IMPORTANT SWAGGER SETUP CONFIGURATION:
/**
 * @OA\Info(title="Soundbank API", version="0.1")
 * * @OA\OpenApi(
 *   @OA\Server( url="http://localhost/soundbank/api/", description="Development Environment")
 * )
 */

/**
 * @OA\Get(
 *     path="/accounts",
 *     @OA\Response(response="200", description="Output all accounts")
 * )
 */
Flight::route("GET /accounts", function() {
    $search = Flight::query('search');
    $offset = Flight::query('offset', 0);
    $limit = Flight::query('limit', 25);
    
    Flight::json(Flight::accountService()->get_accounts($search, $offset, $limit));
    
});

/**
 * @OA\Get(
 *     path="/accounts/id/{id}",
 *     @OA\Response(response="200", description="Output account by id"),
 *     @OA\Parameter(
     *         description="ID of an account",
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(
     *           type="integer",
     *           example=1
     *         )
     *     ),
 * )
 */
Flight::route("GET /accounts/id/@id", function($id) {
    Flight::json(Flight::accountService()->get_by_id($id));
});

/**
 * @OA\Get(
 *     path="/accounts/username/{username}",
 *     @OA\Response(response="200", description="Output account by username"),
 *     @OA\Parameter(
     *         description="username of an account",
     *         in="path",
     *         name="username",
     *         required=true,
     *         @OA\Schema(
     *           type="string",
     *           example="nihad"
     *         )
     *     ),
 * )
 */
Flight::route("GET /accounts/username/@username", function($username) {
    Flight::json(Flight::accountService()->get_by_username($username));
});

/**
 * @OA\Post(
 *     path="/accounts/register/",
 *     @OA\Response(response="200", description="Add account")
 * )
 */
Flight::route("POST /accounts/register", function() {
    $request = Flight::request();
    Flight::accountService()->add($request->data->getData());
});

/**
 * @OA\Put(
 *     path="/accounts/id/{id}",
 *     @OA\Response(response="200", description="Update account by id"),
 *     @OA\Parameter(
     *         description="ID of an account",
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(
     *           type="integer"
     *         )
     *     ),
 * )
 */
Flight::route("PUT /accounts/id/@id", function($id){
    $data = Flight::request()->data->getData();
    Flight::accountService()->update_by_id($id, $data);
    Flight::json(Flight::accountService()->get_by_id($id));
});

?>