<?php 

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once dirname(__FILE__)."/dao/AccountDao.class.php";

$accountDao = new AccountDao();

$account = $accountDao->get_account_by_id(1);
$new_account = [
    "username" => "asda",
];


$accountDao->update_account(3, $new_account);

print_r($account);
echo "</br>";

$account = $accountDao->get_account_by_id(3);
print_r($account);
echo "</br>";
?>