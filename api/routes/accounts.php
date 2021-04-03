<?php
// Displays errors.
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once dirname(__FILE__)."/../dao/AccountDao.class.php";
require_once dirname(__FILE__)."/../services/AccountService.class.php";

// Method for searching accounts by name.
Flight::route("GET /accounts", function() {
    $search = Flight::query('search');
    $offset = Flight::query('offset', 0);
    $limit = Flight::query('limit', 25);
    
    Flight::json(Flight::accountService()->get_accounts($search, $offset, $limit));
    
});

// Getting accounts by id from the database.
Flight::route("GET /accounts/@id", function($id) {
    Flight::json(Flight::accountService()->get_account_by_id($id));
});

// Getting accounts by username from the database.
Flight::route("GET /accounts/@username", function($username) {
    Flight::json(Flight::accountService()->get_account_by_username($username));
});

// Inserting accounts into the database.
Flight::route("POST /accounts", function() {
    $request = Flight::request();
    Flight::accountService()->add_account($request->data->getData());
});

// Updating existing accounts in the database.
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