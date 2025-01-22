<?php
// Connect to the database
$servername = "101.255.101.60";
$username = "michael";
$password = "tomsK9as";
$dbname = "frd";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>