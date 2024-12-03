<?php
$host = "localhost";
$username = "root";
$password = "";
$dbname = "zimbabwe_cricket_db"; 


$conn = new mysql($host, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
