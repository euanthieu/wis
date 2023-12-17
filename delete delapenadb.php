<?php

$servername = "localhost";
$username = "root";
$password = "";

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Drop database
$sql = "DROP DATABASE IF EXISTS delapenadb";
if ($conn->query($sql) === TRUE) {
    echo "Database deleted successfully\n";
} else {
    echo "Error deleting database: " . $conn->error . "\n";
}

$conn->close();

?>
