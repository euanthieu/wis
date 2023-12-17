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

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: Login_Final.php");
    exit();
}

$instructorId = $_SESSION['user_id'];

// Retrieve instructor details
$instructorSql = "SELECT * FROM Instructor WHERE id = $instructorId";
$instructorResult = $conn->query($instructorSql);

if ($instructorResult->num_rows > 0) {
    $instructor = $instructorResult->fetch_assoc();
} else {
    // Handle the case where the instructor data is not found
    echo "Instructor data not found!";
    exit();
}

// Retrieve courses handled by the instructor
$coursesSql = "SELECT * FROM Course WHERE instructorID = $instructorId";
$coursesResult = $conn->query($coursesSql);

// Retrieve enrollment data for the instructor
$enrollmentSql = "SELECT Enrollment.*, Student.firstName AS studentFirstName, Student.lastName AS studentLastName
                  FROM Enrollment
                  JOIN Student ON Enrollment.id = Student.id
                  WHERE Enrollment.courseID IN (SELECT courseID FROM Course WHERE instructorID = $instructorId)";
$enrollmentResult = $conn->query($enrollmentSql);

// Check if the form is submitted for updating grades
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update_grade"])) {
    $enrollmentId = $_POST["enrollment_id"];
    $newGrade = $_POST["new_grade"];

    // Update the grade in the Enrollment table
    $updateGradeSql = "UPDATE Enrollment SET grade = '$newGrade' WHERE enrollmentID = $enrollmentId";
    $conn->query($updateGradeSql);
}

// Check if the form is submitted for creating a new course
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["create_course"])) {
    $courseName = $_POST["course_name"];
    $courseCode = $_POST["course_code"];
    $credits = $_POST["credits"];

    // Insert the new course into the Course table
    $createCourseSql = "INSERT INTO Course (courseName, courseCode, credits, instructorID) 
                        VALUES ('$courseName', '$courseCode', $credits, $instructorId)";
    $conn->query($createCourseSql);

    // Clear posted values to avoid duplication
    $_POST = array();
}

// Check if the form is submitted for deleting the instructor account
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete_account"])) {
    // Delete from Instructor table
    $deleteInstructorSql = "DELETE FROM Instructor WHERE id = $instructorId";
    $conn->query($deleteInstructorSql);

    // Delete from User table
    $deleteUserSql = "DELETE FROM User WHERE id = $instructorId";
    $conn->query($deleteUserSql);

    // Redirect to Login_Final.php
    header("Location: Login_Final.php");
    exit();
}

// Logout logic
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["logout"])) {
    session_destroy();
    header("Location: Login_Final.php");
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome Instructor</title>
    <link rel="stylesheet" href="final.css">

</head>
<body>

    <h2>Welcome, <?php echo $instructor['firstName'] . ' ' . $instructor['lastName']; ?></h2>

    <h3>Your Information</h3>
    <p>Instructor ID: <?php echo $instructor['id']; ?></p>
    <p>Email: <?php echo $instructor['email']; ?></p>
    <p>Phone Number: <?php echo $instructor['phoneNum']; ?></p>

    <!-- 2. Show courses handled by the instructor -->
    <h3>Courses Handled</h3>
    <table border="1">
        <tr>
            <th>Course ID</th>
            <th>Course Name</th>
            <th>Course Code</th>
            <th>Credits</th>
        </tr>
        <?php
        while ($courseRow = $coursesResult->fetch_assoc()) {
            echo "<tr>
                    <td>{$courseRow['courseID']}</td>
                    <td>{$courseRow['courseName']}</td>
                    <td>{$courseRow['courseCode']}</td>
                    <td>{$courseRow['credits']}</td>
                </tr>";
        }
        ?>
    </table>

    <!-- 3. Create a Course form -->
    <h3>Create a New Course</h3>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="course_name">Course Name:</label>
        <input type="text" id="course_name" name="course_name" required><br>

        <label for="course_code">Course Code:</label>
        <input type="text" id="course_code" name="course_code" required><br>

        <label for="credits">Credits:</label>
        <input type="number" id="credits" name="credits" required><br>

        <input type="submit" name="create_course" value="Create Course">
    </form>

    <!-- 4. Enrollment table and grade update -->
    <h3>Enrollment Data</h3>
    <table border="1">
        <tr>
            <th>Enrollment ID</th>
            <th>Student ID</th>
            <th>Course ID</th>
            <th>Enrollment Date</th>
            <th>Grade</th>
            <th>Update Grade</th>
        </tr>
        <?php
        while ($enrollmentRow = $enrollmentResult->fetch_assoc()) {
            echo "<tr>
                    <td>{$enrollmentRow['enrollmentID']}</td>
                    <td>{$enrollmentRow['id']}</td>
                    <td>{$enrollmentRow['courseID']}</td>
                    <td>{$enrollmentRow['enrollmentDate']}</td>
                    <td>{$enrollmentRow['grade']}</td>
                    <td>
                        <form method='post' action='{$_SERVER["PHP_SELF"]}'>
                            <input type='hidden' name='enrollment_id' value='{$enrollmentRow['enrollmentID']}'>
                            <input type='text' name='new_grade' placeholder='Enter New Grade' required>
                            <input type='submit' name='update_grade' value='Update'>
                        </form>
                    </td>
                </tr>";
        }
        ?>
    </table>

    <!-- 5. Delete instructor record button -->
    <h3>Delete Account</h3>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <input type="submit" name="delete_account" value="Delete Account">
    </form>

    <!-- 6. Logout button -->
    <h3>Logout</h3>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <input type="submit" name="logout" value="Logout">
    </form>

</body>
</html>
