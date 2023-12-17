<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "delapenadb";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$firstName = $lastName = $dateOfBirth = $email = $phoneNum = $userType = $username = $password = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName = $_POST["firstName"];
    $lastName = $_POST["lastName"];
    $dateOfBirth = $_POST["dateOfBirth"];
    $email = $_POST["email"];
    $phoneNum = $_POST["phoneNum"];
    $userType = $_POST["userType"];
    $username = $_POST["username"]; // Add this line to capture the username
    $password = $_POST["password"]; // Add this line to capture the password

    // Insert into the appropriate table based on user type
    if ($userType == "student" || $userType == "instructor") {
        // Insert into the User table with username and password
        $sql = "INSERT INTO User (username, password, type) VALUES ('$username', '$password', '$userType')";
        $conn->query($sql);

        $userId = $conn->insert_id;

        // Insert into the specific user type table
        if ($userType == "student") {
            $sql = "INSERT INTO Student (id, firstName, lastName, dateOfBirth, email, phoneNum)
                    VALUES ('$userId', '$firstName', '$lastName', '$dateOfBirth', '$email', '$phoneNum')";
            $conn->query($sql);
        } elseif ($userType == "instructor") {
            $sql = "INSERT INTO Instructor (id, firstName, lastName, email, phoneNum)
                    VALUES ('$userId', '$firstName', '$lastName', '$email', '$phoneNum')";
            $conn->query($sql);
        }

        // Redirect back to Login_Final.php
        header("Location: Login_Final.php");
        exit();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
    <link rel="stylesheet" href="final.css">

</head>
<body>

    <h2>User Registration</h2>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="firstName">First Name:</label>
        <input type="text" id="firstName" name="firstName" required><br>

        <label for="lastName">Last Name:</label>
        <input type="text" id="lastName" name="lastName" required><br>

        <label for="dateOfBirth">Date of Birth:</label>
        <input type="date" id="dateOfBirth" name="dateOfBirth"><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br>

        <label for="phoneNum">Phone Number:</label>
        <input type="text" id="phoneNum" name="phoneNum" required><br>

        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br>

        <label>User Type:</label>
        <input type="radio" id="student" name="userType" value="student" checked>
        <label for="student">Student</label>
        <input type="radio" id="instructor" name="userType" value="instructor">
        <label for="instructor">Instructor</label><br>

        <input type="submit" value="Register">
    </form>

    <br>
    <a href="Login_Final.php">Back to Login</a>

</body>
</html>
