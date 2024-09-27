<?php
$servername = "localhost";
$username = "xeu";
$password = "@1qaz2wsx";
$db = "livershop";

$conn=mysqli_connect($servername,$username,$password,$db);
if (!$conn) {
 die("Connection failed: ".mysqli_connect_error());
}
// echo "Connected successfully";

?>