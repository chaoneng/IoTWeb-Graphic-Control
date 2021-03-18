<?php
// header('Content-Type: application/json; charset=UTF-8');
include('./mysql_connect.php');
$name = $_POST['name'];
$file_name = str_replace("." . strtolower(pathinfo($name, PATHINFO_EXTENSION)), "", $name); //把(點+副檔名)給刪除掉，這樣在匯出的時候就不會.JPG.JSON很醜的檔名
$image = './images/' . $name;
$pointsX = $_POST['pointsX'];
$pointsY = $_POST['pointsY'];
$icon = $_POST['icon'];
$text  = $_POST['text'];
var_dump($icon);
var_dump($text);
$sql = "SELECT `name` from images where name = '$file_name'";
$query = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($query);

if ($row == null) {
    $sql = "INSERT INTO images VALUES(NULL,'{$file_name}','{$image}','$pointsX','$pointsY','$icon','$text');";
    $query = mysqli_query($conn, $sql);
} else {
    $sql = "UPDATE images set x='{$pointsX}',y='{$pointsY}',icon='{$icon}',text='{$text}' where name = '$file_name'";
    $query = mysqli_query($conn, $sql);
}
