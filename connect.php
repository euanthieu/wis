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
    include 'showTables.php';


?>    
</body>
</html>

