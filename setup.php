<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "delapenadb";

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create database if it doesn't exist
$sql = "CREATE DATABASE IF NOT EXISTS $dbname";
$conn->query($sql);

// Select the database
$conn->select_db($dbname);

// Create User table
$sql = "CREATE TABLE IF NOT EXISTS User (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(50) NOT NULL,
    type VARCHAR(20) NOT NULL
)";
$conn->query($sql);

// Create Student table
$sql = "CREATE TABLE IF NOT EXISTS Student (
    id INT PRIMARY KEY,
    firstName VARCHAR(50) NOT NULL,
    lastName VARCHAR(50) NOT NULL,
    dateOfBirth DATE,
    email VARCHAR(50) NOT NULL,
    phoneNum VARCHAR(20) NOT NULL,
    FOREIGN KEY (id) REFERENCES User(id)
)";
$conn->query($sql);

// Create Instructor table
$sql = "CREATE TABLE IF NOT EXISTS Instructor (
    id INT PRIMARY KEY,
    firstName VARCHAR(50) NOT NULL,
    lastName VARCHAR(50) NOT NULL,
    email VARCHAR(50) NOT NULL,
    phoneNum VARCHAR(20) NOT NULL,
    FOREIGN KEY (id) REFERENCES User(id)
)";
$conn->query($sql);

// Create Course table
$sql = "CREATE TABLE IF NOT EXISTS Course (
    courseID INT AUTO_INCREMENT PRIMARY KEY,
    courseName VARCHAR(50) NOT NULL,
    courseCode VARCHAR(20) NOT NULL,
    credits INT NOT NULL,
    instructorID INT,
    FOREIGN KEY (instructorID) REFERENCES Instructor(id)
)";
$conn->query($sql);

// Create Enrollment table
$sql = "CREATE TABLE IF NOT EXISTS Enrollment (
    enrollmentID INT AUTO_INCREMENT PRIMARY KEY,
    id INT,
    courseID INT,
    instructorID INT,
    enrollmentDate DATE,
    grade VARCHAR(5),
    FOREIGN KEY (id) REFERENCES Student(id),
    FOREIGN KEY (courseID) REFERENCES Course(courseID),
    FOREIGN KEY (instructorID) REFERENCES Instructor(id)
)";
$conn->query($sql);

// Check if data exists before adding values
$userCheckSql = "SELECT id FROM User LIMIT 1";
$userCheckResult = $conn->query($userCheckSql);

if ($userCheckResult->num_rows == 0) {
    // Add student
    $sql = "INSERT INTO User (username, password, type) VALUES ('student', 'root', 'student')";
    $conn->query($sql);

    $studentId = $conn->insert_id;
    $studentIdFormatted = '01-' . date('md') . substr(2003, -2);

    $sql = "INSERT INTO Student (id, firstName, lastName, dateOfBirth, email, phoneNum) 
            VALUES ('$studentId', 'Euan', 'Mathieu', '2003-02-09', 'euanthieu@gmail.com', '0990808552')";
    $conn->query($sql);

    // Add instructor
    $sql = "INSERT INTO User (username, password, type) VALUES ('instructor', 'root', 'instructor')";
    $conn->query($sql);

    $instructorId = $conn->insert_id;
    $instructorIdFormatted = '00-' . date('md') . substr(2004, -2);

    $sql = "INSERT INTO Instructor (id, firstName, lastName, email, phoneNum) 
            VALUES ('$instructorId', 'Prim', 'User', 'primusr@gmail.com', '0990808553')";
    $conn->query($sql);
}

$conn->close();

// Redirect to Login_Final.php
header("Location: Login_Final.php");
exit();
?>
