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

$userId = $_SESSION['user_id'];

// Retrieve student details
$studentSql = "SELECT * FROM Student WHERE id = $userId";
$studentResult = $conn->query($studentSql);

if ($studentResult->num_rows > 0) {
    $student = $studentResult->fetch_assoc();
} else {
    // Handle the case where the student data is not found
    echo "Student data not found!";
    exit();
}

// Retrieve enrolled courses for the student with instructor information
$enrolledCoursesSql = "SELECT Course.*, Instructor.lastName AS instructorLastName
                      FROM Course
                      JOIN Enrollment ON Course.courseID = Enrollment.courseID
                      JOIN Instructor ON Course.instructorID = Instructor.id
                      WHERE Enrollment.id = $userId";
$enrolledCoursesResult = $conn->query($enrolledCoursesSql);

// Retrieve available courses
$availableCoursesSql = "SELECT * FROM Course WHERE courseID NOT IN (SELECT courseID FROM Enrollment WHERE id = $userId)";
$availableCoursesResult = $conn->query($availableCoursesSql);

// Retrieve enrollment data linked with the student
$enrollmentDataSql = "SELECT Enrollment.*, Course.courseName, Course.courseCode, Instructor.lastName AS instructorLastName
                      FROM Enrollment
                      JOIN Course ON Enrollment.courseID = Course.courseID
                      JOIN Instructor ON Course.instructorID = Instructor.id
                      WHERE Enrollment.id = $userId";
$enrollmentDataResult = $conn->query($enrollmentDataSql);

// Check if the form is submitted for enrolling in a course
$enrollMessage = "";
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["enroll_course"])) {
    $selectedCourseId = $_POST["course_id"];

    // Check if a course is selected
    if (empty($selectedCourseId)) {
        $enrollMessage = "Please choose a course";
    } else {
        // Check if the student is already enrolled in the selected course
        $checkEnrollmentSql = "SELECT * FROM Enrollment WHERE id = $userId AND courseID = $selectedCourseId";
        $checkEnrollmentResult = $conn->query($checkEnrollmentSql);

        if ($checkEnrollmentResult->num_rows > 0) {
            $enrollMessage = "You are already enrolled in this course";
        } else {
            // Fetch instructorID for the selected course
            $instructorIdSql = "SELECT instructorID FROM Course WHERE courseID = $selectedCourseId";
            $instructorIdResult = $conn->query($instructorIdSql);

            if ($instructorIdResult->num_rows > 0) {
                $instructorIdRow = $instructorIdResult->fetch_assoc();
                $instructorID = $instructorIdRow['instructorID'];

                // Perform the enrollment, insert data into the Enrollment table
                $enrollSql = "INSERT INTO Enrollment (id, courseID, instructorID, enrollmentDate, grade) VALUES ('$userId', '$selectedCourseId', '$instructorID', CURDATE(), NULL)";
                $conn->query($enrollSql);
            }
        }
    }
}

// Check if the form is submitted for deleting the student account
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete_account"])) {
    // Delete from Enrollment table
    $deleteEnrollmentSql = "DELETE FROM Enrollment WHERE id = $userId";
    $conn->query($deleteEnrollmentSql);

    // Delete from Student table
    $deleteStudentSql = "DELETE FROM Student WHERE id = $userId";
    $conn->query($deleteStudentSql);

    // Delete from User table
    $deleteUserSql = "DELETE FROM User WHERE id = $userId";
    $conn->query($deleteUserSql);

    // Redirect to the homepage
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
    <title>Welcome Student</title>
    <link rel="stylesheet" href="final.css">
</head>
<body>
    <h2>Welcome, <?php echo $student['firstName'] . ' ' . $student['lastName']; ?></h2>

    <h3>Your Information</h3>
    <p>Student ID: <?php echo $student['id']; ?></p>
    <p>Date of Birth: <?php echo $student['dateOfBirth']; ?></p>
    <p>Email: <?php echo $student['email']; ?></p>
    <p>Phone Number: <?php echo $student['phoneNum']; ?></p>

    <h3>Your Courses</h3>
    <table border="1">
        <tr>
            <th>Course ID</th>
            <th>Course Name</th>
            <th>Course Code</th>
            <th>Credits</th>
            <th>Instructor</th>
        </tr>
        <?php
        while ($row = $enrolledCoursesResult->fetch_assoc()) {
            echo "<tr>";
            echo "<td>{$row['courseID']}</td>";
            echo "<td>{$row['courseName']}</td>";
            echo "<td>{$row['courseCode']}</td>";
            echo "<td>{$row['credits']}</td>";
            echo "<td>{$row['instructorLastName']}</td>";
            echo "</tr>";
        }
        ?>
    </table>

    <h3>Enrollment Data</h3>
    <table border="1">
        <tr>
            <th>Enrollment ID</th>
            <th>Course ID</th>
            <th>Enrollment Date</th>
            <th>Grade</th>
            <th>Instructor</th>
        </tr>
        <?php
        while ($enrollmentRow = $enrollmentDataResult->fetch_assoc()) {
            echo "<tr>
                    <td>{$enrollmentRow['enrollmentID']}</td>
                    <td>{$enrollmentRow['courseID']}</td>
                    <td>{$enrollmentRow['enrollmentDate']}</td>
                    <td>{$enrollmentRow['grade']}</td>
                    <td>{$enrollmentRow['instructorLastName']}</td>
                </tr>";
        }
        ?>
    </table>

    <h3>Available Courses</h3>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <select name="course_id">
            <option value="">Select a course</option>
            <?php
            // Reset the pointer of the result set for available courses
            $availableCoursesResult->data_seek(0);
            
            while ($row = $availableCoursesResult->fetch_assoc()) {
                echo "<option value='{$row['courseID']}'>{$row['courseName']}</option>";
            }
            ?>
        </select>
        <input type="submit" name="enroll_course" value="Enroll">
        <p style="color: red;"><?php echo $enrollMessage; ?></p>
    </form>

    <h3>Delete Account</h3>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <input type="submit" name="delete_account" value="Delete Account">
    </form>

    <h3>Logout</h3>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <input type="submit" name="logout" value="Logout">
    </form>

</body>
</html>
