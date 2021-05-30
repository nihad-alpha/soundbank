<?php

Flight::before('start', function (&$params, &$output) {
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
});

?>