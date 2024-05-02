<?php
	$servername = "localhost";
$username = "u219718432_proflujo";
$password = "Vm#15081947";
$dbname = "u219718432_rotary_event";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}