<?php
// header("content-type:text/html; charset=utf-8");
/**
 * Created by PhpStorm.
 * User: refar
 * Date: 18-4-14
 * Time: 下午4:04
 */
require_once "connection.php";

$sql = "select * from student";
$result = mysqli_query($conn,$sql);

$jsonResult = array();
while($row = $result->fetch_assoc()){
    array_push($jsonResult, $row);
}

echo json_encode($jsonResult);
$conn->close();