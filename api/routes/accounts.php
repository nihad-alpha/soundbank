<?php
// Displays errors.
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once dirname(__FILE__)."/../dao/AccountDao.class.php";

Flight::route("GET /accounts", function() {
    Flight::json(Flight::accountDao()->get_all_accounts());
});

Flight::route("GET /accounts/@id", function($id) {
    Flight::json(Flight::accountDao()->get_account_by_id($id));
});

?>