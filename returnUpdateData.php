<?php
/**
 * Created by PhpStorm.
 * User: refar
 * Date: 18-5-2
 * Time: 上午10:52
 */

require_once "connection.php";

$id = $_POST['id'];
$sql = "select * from student where id = ";
$jsonResult = array();
if (count($id) == 1){
    $sql = $sql. $id[0];
    $result = mysqli_query($conn, $sql);
    while($row = $result->fetch_assoc()){
        array_push($jsonResult, $row);
    }

    echo json_encode($jsonResult);

}

