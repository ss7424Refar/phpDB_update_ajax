<?php
/**
 * Created by PhpStorm.
 * User: refar
 * Date: 18-4-15
 * Time: 下午3:55
 */

require_once "../connection.php";

$sql = "delete from student where id = 1";

mysqli_query($conn, $sql);
echo mysqli_affected_rows($conn);