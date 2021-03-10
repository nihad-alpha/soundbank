<?php 

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


require_once dirname(__FILE__)."/dao/AccountDao.class.php";

echo "Welcome to the API.";
$accountDao = new AccountDao();

$account = $accountDao->get_account_by_username("alpha");
print_r($account);
echo "Printed!";
?>