<?php
// Filter-based Middleware (By the book option, not very flexible)
require_once dirname(__FILE__)."/../config.php";

/* middleware for regular users */
/*Flight::route('/accounts/*', function(){
    $headers = getallheaders();
    $token = @$headers['Authentication'];

    try {
      $decoded = (array)\Firebase\JWT\JWT::decode($token, Config::JWT_SECRET, ["HS256"]);
      print_r($decoded);
      die;
      if (Flight::request()->method != "GET" && $decoded['account_type'] != "ADMIN"){
        throw new Exception("You are not the administrator.", 403);
      }
      Flight::set('account', $decoded['id']);
      return TRUE;
    } catch (\Exception $e) {
      Flight::json(["message" => $e->getMessage()], 401);
      die;
    }
  });*/

Flight::route('/*', function () {
    if (Flight::request()->url == "/swagger") return TRUE;
    if (str_starts_with (Flight::request()->url, '/accounts/login')) return TRUE;
    if (str_starts_with (Flight::request()->url, '/accounts/register')) return TRUE;
    if (str_starts_with (Flight::request()->url, '/accounts/forgot')) return TRUE;
    if (str_starts_with (Flight::request()->url, '/accounts/confirm')) return TRUE;
    if (str_starts_with (Flight::request()->url, '/accounts/reset')) return TRUE;
    if (str_starts_with (Flight::request()->url, '/artists')) return TRUE;
    if (Flight::request()->url == '/') return TRUE;

    $headers = getallheaders();
    $token = @$headers['Authentication'];
    
    try {
        $decoded = (array)\Firebase\JWT\JWT::decode($token, Config::JWT_SECRET, ["HS256"]);
        if (Flight::request()->method != "GET" && $decoded['account_type'] != "ADMIN"){
            throw new Exception("You are not the administrator.", 403);
        }
        Flight::set('account', $decoded['id']);
        return TRUE;
    } catch (\Exception $e) {
        Flight::json(["message" => "Unauthorized access."]);
        die;
    }
});

// Route-based Middleware (Much more flexible, now you can add multiple middlewares for each role level).
/*Flight::route('/*', function () {
    if (Flight::request()->url == "/swagger") return TRUE;
    if (str_starts_with (Flight::request()->url, '/accounts/login')) return TRUE;
    if (str_starts_with (Flight::request()->url, '/accounts/register')) return TRUE;
    if (str_starts_with (Flight::request()->url, '/accounts/forgot')) return TRUE;
    if (str_starts_with (Flight::request()->url, '/accounts/confirm')) return TRUE;

    $headers = getallheaders();
    $token = @$headers['Authentication'];
    
    try {
        $decoded = (array)\Firebase\JWT\JWT::decode($token, "JWT_SECRET", ["HS256"]);
        return TRUE;
    } catch (\Exception $e) {
        Flight::json(["message" => "Unauthorized access."]);
        die;
    }
});*/

?>