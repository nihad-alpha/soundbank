<?php

Flight::route("GET /accounts", function() {
    $search = Flight::query('search');
    $offset = Flight::query('offset', 0);
    $limit = Flight::query('limit', 25);
    
    Flight::json(Flight::accountService()->search_accounts($search, $offset, $limit));
    
});

Flight::route("GET /accounts/@id", function($id) {
    Flight::json(Flight::accountService()->get_account_by_id($id));
});

Flight::route("GET /accounts/@username", function($username) {
    Flight::json(Flight::accountService()->get_account_by_username($username));
});

Flight::route("POST /accounts", function() {
    $request = Flight::request();
    Flight::accountService()->add_account($request->data->getData());
});

Flight::route("PUT /accounts/@id", function($id){
    $data = Flight::request()->data->getData();
    Flight::accountService()->update_account_by_id($id, $data);
    Flight::json(Flight::accountService()->get_account_by_id($id));
});

// Route made for understanding the mechanics of FlightPHP and other frameworks. NOT NECESSARY FOR PROJECT!
Flight::route ("GET /learn", function () {
    Flight::json(Flight::request()->data->getData());
});

?>