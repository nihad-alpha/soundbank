<?php
// Displays errors.
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

Flight::route("GET /accounts", function() {
    $search = Flight::query('search');
    $offset = Flight::query('offset', 0);
    $limit = Flight::query('limit', 25);
    
    Flight::json(Flight::accountService()->get_accounts($search, $offset, $limit));
    
});

Flight::route("GET /accounts/id/@id", function($id) {
    Flight::json(Flight::accountService()->get_by_id($id));
});

Flight::route("GET /accounts/username/@username", function($username) {
    Flight::json(Flight::accountService()->get_by_username($username));
});

Flight::route("POST /accounts/register", function() {
    $request = Flight::request();
    Flight::accountService()->add($request->data->getData());
});

Flight::route("PUT /accounts/id/@id", function($id){
    $data = Flight::request()->data->getData();
    Flight::accountService()->update_by_id($id, $data);
    Flight::json(Flight::accountService()->get_by_id($id));
});

?>