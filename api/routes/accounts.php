<?php
// Displays errors.
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Swagger API

/**
 * @OA\Info(title="Soundbank API", version="0.1")
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
 *     path="/accounts/{id}",
 *     @OA\Response(response="200", description="Output account by id"),
 *     @OA\Parameter(
     *         description="ID of an account",
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(
     *           type="integer",
     *           default=1
     *         )
     *     ),
 * )
 */
Flight::route("GET /accounts/id/@id", function($id) {
    Flight::json(Flight::accountService()->get_by_id($id));
});

Flight::route("GET /accounts/username/@username", function($username) {
    Flight::json(Flight::accountService()->get_by_username($username));
});

Flight::route("POST /accounts", function() {
    $request = Flight::request();
    Flight::accountService()->add($request->data->getData());
});

Flight::route("PUT /accounts/id/@id", function($id){
    $data = Flight::request()->data->getData();
    Flight::accountService()->update_by_id($id, $data);
    Flight::json(Flight::accountService()->get_by_id($id));
});

?>