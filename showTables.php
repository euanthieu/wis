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
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Document</title>
</head>
<body>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<?php 

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