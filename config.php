<?php

// user pass database
$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'dbperpustakaan';

$mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name);

if ($mysqli->connect_error) {
    die("Koneksi Rusak : " . $mysqli->connect_error);
}
?>