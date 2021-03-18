<?php
header('Content-Type: application/json charset=UTF-8');
include('./mysql_connect.php');
$str = $_POST['str'];
$sql = "SELECT * from images where name='$str'";
$query = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($query);
echo json_encode($row);
