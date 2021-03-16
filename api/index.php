<?php 

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once dirname(__FILE__)."/dao/AccountDao.class.php";
require_once dirname(__FILE__)."/dao/AlbumDao.class.php";

$accountDao = new AccountDao();
$baseDao = new BaseDao();


$new_account = [
    "username" => "cokosmoki",
];

$addedAccount = $accountDao->add_account($new_account);

print_r($addedAccount);
?>