<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "delapenadb";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to display table contents
function displayTable($conn, $tableName)
{
    $sql = "SELECT * FROM $tableName";
    $result = $conn->query($sql);

    echo "<h2>$tableName Table</h2>";
    echo "<table border='1'><tr>";

    // Display column names
    $fields = $result->fetch_fields();
    foreach ($fields as $field) {
        echo "<th>$field->name</th>";
    }

    echo "</tr>";

    // Display table contents
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        foreach ($row as $value) {
            echo "<td>$value</td>";
        }
        echo "</tr>";
    }

    echo "</table><br>";
}

// Display tables and their contents
$tables = ['User', 'Student', 'Instructor', 'Course', 'Enrollment'];
foreach ($tables as $table) {
    displayTable($conn, $table);
}

$conn->close();

?>
