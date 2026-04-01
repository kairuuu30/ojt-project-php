<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "id_validation";

date_default_timezone_set("Asia/Manila");
$date_time_today = date("Y-m-d H:i:s");

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
// echo 'Successful';
?>