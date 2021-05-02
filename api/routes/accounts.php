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
 * @OA\Get( path="/accounts", tags={"account"},
 *     @OA\Parameter(type="string", in="query", name="search", default=""),
 *     @OA\Parameter(type="integer", in="query", name="offset", default=0),
 *     @OA\Parameter(type="integer", in="query", name="limit", default=25),
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
 * @OA\Get( path="/accounts/id/{id}", tags={"account"},
 *     @OA\Parameter(type="integer", in="path", name="id"),
 *     @OA\Response(response="200", description="Output all accounts")
 * )
 */
Flight::route("GET /accounts/id/@id", function($id) {
    Flight::json(Flight::accountService()->get_by_id($id));
});

/**
 * @OA\Get( path="/accounts/username/{username}", tags={"account"},
 *     @OA\Parameter(type="string", in="path", name="username"),
 *     @OA\Response(response="200", description="Output all accounts")
 * )
 */
Flight::route("GET /accounts/username/@username", function($username) {
    Flight::json(Flight::accountService()->get_by_username($username));
});

/**
 * @OA\Post(
 *     path="/accounts/register/", tags={"account"},
 *     @OA\Response(response="200", description="Add account")
 * )
 */
Flight::route("POST /accounts/register", function() {
    $request = Flight::request();
    Flight::accountService()->add($request->data->getData());
});

/**
 * @OA\Put( path="/accounts/id/{id}", tags={"account"},
 *     @OA\Parameter(type="integer", in="path", name="id"),
 *     @OA\Response(response="200", description="Output all accounts")
 * )
 */
Flight::route("PUT /accounts/id/@id", function($id){
    $data = Flight::request()->data->getData();
    Flight::accountService()->update_by_id($id, $data);
    Flight::json(Flight::accountService()->get_by_id($id));
});

?>