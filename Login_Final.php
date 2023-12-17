<?php
session_start(); // Start the session

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

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $enteredUsername = $_POST["username"];
    $enteredPassword = $_POST["password"];

    // Perform SQL query to check if the username and password match
    $sql = "SELECT * FROM User WHERE username = '$enteredUsername' AND password = '$enteredPassword'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Valid credentials, get user details
        $user = $result->fetch_assoc();

        // Store user ID in the session
        $_SESSION['user_id'] = $user['id'];

        // Check user type
        $userType = $user['type'];

        // Redirect to appropriate page based on user type
        if ($userType == 'student') {
            header("Location: student_welcome.php");
            exit();
        } elseif ($userType == 'instructor') {
            header("Location: instructor_welcome.php");
            exit();
        } else {
            $error_message = "Invalid user type";
        }
    } else {
        $error_message = "Invalid username or password";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="final.css">

</head>
<body>

    <h2>Login</h2>

    <?php
    if (isset($error_message)) {
        echo "<p style='color:red;'>$error_message</p>";
    }
    ?>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br>

        <input type="submit" value="Login">
    </form>

    <p>Don't have an account? <a href="register.php">Create an Account</a></p>

</body>
</html>
