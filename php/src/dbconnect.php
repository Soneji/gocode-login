<?php
$servername = "db";
$username = "gocode";
$password = "gocode";
$dbname = "gocode";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}
?>
