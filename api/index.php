<?php 

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once dirname(__FILE__)."/dao/AccountDao.class.php";
require_once dirname(__FILE__)."/dao/AlbumDao.class.php";

$accountDao = new AccountDao();
$baseDao = new BaseDao();


$new_account = [
    "username" => "asdas",
];

$baseDao->insert("accounts", $new_account);

$accountDao->update_account(3, $new_account);

$account = $accountDao->get_account_by_id(3);
print_r($account);
echo "</br>";

$new_album = [
    "album_name" => "MMLP2",
    "account_id" => "4",
    "album_genre" => "Rap",
    "cover_art_path" => "C:\Users\Nihad\Desktop\art.jpg",
    "upload_date" => "2021/10/12",
    "album_length" => "4740"
];

$albumDao = new AlbumDao();
$albumDao->update_album(1, $new_album);

$album = $albumDao->get_album_by_id(1);

print_r($album);
?>