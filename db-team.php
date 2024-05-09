<?php
	$servername = "localhost";
$username = "u219718432_event";
$password = "kia@Seltos1";
$dbname = "u219718432_event";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}