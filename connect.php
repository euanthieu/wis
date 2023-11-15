<!DOCTYPE html>
<html lang="en">
<style>
table{

  border-right:0px;
  border-left:1px solid black;
  border-top:1px solid black;
  border-bottom:1px solid black;
  margin:10px;
}
td{
  border-right:1px solid black;
  margin:10px;
}
th{
  border-bottom:1px solid black;
  border-right:1px solid black;
  margin:10px;
}
</style>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php 
$serverName = "localhost";
$userName = "root";
$password = "";
$dbName = "studentrecord";
$conn = new mysqli($serverName,$userName,$password,$dbName);

    if ($conn->connect_error){
        die("Connection Failed." . $conn->connect_error);
    }
    // else{
    //     echo "Connected Successfully";
    // }

//Student    
$showstud="select * from student";    
$result=$conn->query("$showstud");
        echo "<br>". "<b>Students:</b>"."<br>";
        echo "<table>";
        echo '<th>StudentID</th>';
        echo '<th>Last Name</th>';
        echo '<th>First Name</th>';
        echo '<th>Date Of Birth</th>';
        echo '<th>Email</th>';
        echo '<th>Phone</th></tr>';
         
if($result){
    while($row=$result->fetch_assoc()){

        echo "<tr><td>". $row["StudentID"]."</td>";
        echo "<td>" . $row["LastName"]."</td>";
        echo "<td>" . $row["FirstName"]."</td>";
        echo "<td>" . $row["DateOfBirth"]."</td>";
        echo "<td>" . $row["Email"]."</td>";
        echo "<td>" . $row["Phone"]."</td>";
        echo "</tr></table>";
    
    }
}else{

    echo "Error: ". $sql ."<br>".$conn->error;
}

//Course
$showCourse="select * from course";    
$result=$conn->query("$showCourse");
        echo "<br>". "<b>Course:</b>"."<br>";
        echo "<table>";
        echo '<tr><th>CourseID</th>';
        echo '<th>CourseName</th>';
        echo '<th>Credits</th></tr>';
        
if($result){
    while($row=$result->fetch_assoc()){

        echo "<tr><td>". $row["CourseID"]."</td>";
        echo "<td>" . $row["CourseName"]."</td>";
        echo "<td>" . $row["Credits"]."</td>";
        echo '</th></table>';    
    }
}else{

    echo "Error: ". $sql ."<br>".$conn->error;
}

//Enrollment
$showEnroll="select * from enrollment";    
$result=$conn->query("$showEnroll");
        echo "<br>". "<b>Enrollment:</b>"."<br>";
        echo "<table>";
        echo '<tr><th>EnrolmentID</th>';
        echo '<th>StudentID</th>';
        echo '<th>CourseID</th>';
        echo '<th>Enrollment Date</th>';
        echo '<th>Grade</th></th>';
if($result){
    while($row=$result->fetch_assoc()){

        echo "<tr><td>". $row["EnrollmentID"]."</td>";
        echo "<td>". $row["StudentID"]."</td>";
        echo "<td>". $row["CourseID"]."</td>";
        echo "<td>" . $row["EnrollmentDate"]."</td>";
        echo "<td>" . $row["Grade"]."</td>";
        echo "</tr></table>";    
    }
}else{

    echo "Error: ". $sql ."<br>".$conn->error;
}

//Instructor    
$showIns="select * from instructor";    
$result=$conn->query("$showIns");
        echo "<br>". "<b>Instructor:</b>"."<br>";
        echo "<table>";
        echo '<th>InstructorID</th>';
        echo '<th>Last Name</th>';
        echo '<th>First Name</th>';
        echo '<th>Email</th>';
        echo '<th>Phone</th></tr>';
if($result){
    while($row=$result->fetch_assoc()){

        echo "<tr><td>". $row["InstructorID"]."</td>";
        echo "<td>" . $row["LastName"]."</td>";
        echo "<td>" . $row["FirstName"]."</td>";
        echo "<td>" . $row["Email"]."</td>";
        echo "<td>" . $row["Phone"]."</td></tr></table>";
    
    }
}else{

    echo "Error: ". $sql ."<br>".$conn->error;
}

?>    
</body>
</html>

