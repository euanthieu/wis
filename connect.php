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

