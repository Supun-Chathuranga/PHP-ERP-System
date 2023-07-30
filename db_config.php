<?php
// db_config.php
$host = "localhost";
$username = "your_db_username";
$password = "your_db_password";
$db_name = "your_db_name";

$conn = new mysqli($host, $username, $password, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}