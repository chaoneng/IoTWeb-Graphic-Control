<?php
$db_server = "127.0.0.1";
$db_name = "case";
$db_user = "root";
$db_password = "123456";
$conn = mysqli_connect($db_server, $db_user, $db_password, $db_name);
mysqli_set_charset($conn, 'utf8');
if (!$conn) {
    exit('<h1>連線失敗</h1>');
}
