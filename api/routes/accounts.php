<?php
// Displays errors.
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once dirname(__FILE__)."/../dao/AccountDao.class.php";

Flight::route("GET /accounts", function() {
    Flight::json(Flight::accountDao()->get_all_account());
});

Flight::route("GET /accounts/@id", function($id) {
    Flight::json(Flight::accountDao()->get_account_by_id($id));
});

Flight::route("GET /accounts/@username", function($username) {
    Flight::json(Flight::accountDao()->get_account_by_username($username));
});

Flight::route("POST /accounts", function() {
    $request = Flight::request();
    Flight::accountDao()->add_account($request->data->getData());
});

Flight::route("PUT /accounts/@id", function($id){
    $data = Flight::request()->data->getData();
    Flight::accountDao()->update_account_by_id($id, $data);
    Flight::json(Flight::accountDao()->get_account_by_id($id));
});

?>