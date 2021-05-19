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
 *     @OA\Parameter(type="string", in="query", name="search", default=null, description="Parameter that allows searching through accounts."),
 *     @OA\Parameter(type="integer", in="query", name="offset", default=0, description="Parameter that sets the starting position from which we start fetching accounts."),
 *     @OA\Parameter(type="integer", in="query", name="limit", default=25, description="Parameter that limits how many accounts are fetched."),
 *     @OA\Parameter(type="string", in="query", name="order", default="-id", description="Parameter that defines order."),
 *     @OA\Response(response="200", description="Fetch all accounts.")
 * )
 */
Flight::route("GET /accounts", function() {
    $search = Flight::query('search');
    $offset = Flight::query('offset', 0);
    $limit = Flight::query('limit', 25);
    $order = Flight::query('order');
    
    Flight::json(Flight::accountService()->get_accounts($search, $offset, $limit, $order));
    
});

/**
* @OA\Post(
*     path="/accounts/register", 
*     tags={"account"},
*     @OA\RequestBody(
*         required=true,
*         @OA\MediaType(
*             mediaType="application/json",
*             @OA\Schema(
*                 @OA\Property(
*                     description="Username of the account",
*                     property="username",
*                     type="string",
*                     example = "USERNAME_EXAMPLE"
*                 ),
*                 @OA\Property(
*                     description="Password of the account",
*                     property="password",
*                     type="string",
*                     example = "PASSWORD_EXAMPLE"
*                 ),
*                 @OA\Property(
*                     description="Email of the account",
*                     property="email",
*                     type="string",
*                     example = "EMAIL_EXAMPLE@DOMAIN.COM"
*                 )
*              )
*        )
*     ),
*     @OA\Response(response="200", description="Add a new account.")
* )
*/
Flight::route("POST /accounts/register", function() {
    Flight::json(Flight::accountService()->register(Flight::request()->data->getData()));
});

Flight::route("GET /accounts/confirm/@token", function($token) {
    Flight::accountService()->confirm($token);
    Flight::json(["message" => "Account with token ${token} is confirmed."]);
});

/**
 * @OA\Get( path="/accounts/{id}", tags={"account"},
 *     @OA\Parameter(type="integer", in="path", name="id", default=0, description="ID of the account you want to fetch."),
 *     @OA\Response(response="200", description="Fetch an account by ID.")
 * )
 */
Flight::route("GET /accounts/@id", function($id) {
    Flight::json(Flight::accountService()->get_by_id($id));
});

/**
* @OA\Post(
*     path="/accounts", 
*     tags={"account"},
*     @OA\RequestBody(
*         required=true,
*         @OA\MediaType(
*             mediaType="application/json",
*             @OA\Schema(
*                 @OA\Property(
*                     description="Username of the account",
*                     property="username",
*                     type="string",
*                     example = "USERNAME_EXAMPLE"
*                 ),
*                 @OA\Property(
*                     description="Password of the account",
*                     property="password",
*                     type="string",
*                     example = "PASSWORD_EXAMPLE"
*                 ),
*                 @OA\Property(
*                     description="Email of the account",
*                     property="email",
*                     type="string",
*                     example = "EMAIL_EXAMPLE@DOMAIN.COM"
*                 )
*              )
*        )
*     ),
*     @OA\Response(response="200", description="Add a new account.")
* )
*/
Flight::route("POST /accounts", function() {
    $request = Flight::request();
    Flight::accountService()->add($request->data->getData());
});

/**
* @OA\Put( path="/accounts/{id}", tags={"account"},
*     @OA\Parameter(type="integer", in="path", name="id", default=0, description="ID of the account you want to update."),
*     @OA\RequestBody(
*         required=true,
*         @OA\MediaType(
*             mediaType="application/json",
*             @OA\Schema(
*                 @OA\Property(
*                     description="Username of the account",
*                     property="username",
*                     type="string",
*                     example = "USERNAME_EXAMPLE"
*                 ),
*                 @OA\Property(
*                     description="Password of the account",
*                     property="password",
*                     type="string",
*                     example = "PASSWORD_EXAMPLE"
*                 ),
*                 @OA\Property(
*                     description="Email of the account",
*                     property="email",
*                     type="string",
*                     example = "EMAIL_EXAMPLE@DOMAIN.COM"
*                 )
*              )
*        )
*     ),
*     @OA\Response(response="200", description="Update an account by ID.")
* )
*/
Flight::route("PUT /accounts/@id", function($id){
    $data = Flight::request()->data->getData();
    Flight::accountService()->update_by_id($id, $data);
    Flight::json(Flight::accountService()->get_by_id($id));
});

?>