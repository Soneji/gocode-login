<?php 
session_start(); 

define('DS',  TRUE); // used to protect includes
define('USERNAME', $_SESSION['username']);
define('SELF',  $_SERVER['PHP_SELF'] );

if (!USERNAME or isset($_GET['logout']))
	include('login.php');

// everything below will show after correct login 
?>
<!-- html boilerplate -->
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Add Student</title>
	<link rel="stylesheet" type="text/css" href="index.css">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
	<a href="addstudent.php"><div style="display: inline-block;float: left;">Back</div></a>
	<a href="index.php?logout"><div style="display: inline-block;float: right;">Logout</div></a>
	<br>
	<h1>Add Student</h1>

<?php
// connect to database
require '../dbconnect.php';

// check if the forename and surname are blank
if(isset($_POST['Forename']) && isset($_POST['Surname']) && $_POST['Forename']!="" && $_POST['Surname']!=""){
	// escape and set variables
	$forename = mysqli_real_escape_string($conn,$_POST['Forename']);
	$surname = mysqli_real_escape_string($conn,$_POST['Surname']);
	// form sql query to check if the user already exists
	$check="SELECT * FROM `students` WHERE Forename='".$forename."' AND Surname='".$surname."' ";
	$res = $conn->query($check);
	// if there is any student with same name throw error
	if($res->num_rows){
		echo "<br><br>User Already in Exists<br/>";
		$conn->close();
	// otherwise form sql to insert student to database 
	} else{
		// sql
		$add = "INSERT INTO `students` (`StudentID`, `Forename`, `Surname`) VALUES (NULL, '".$forename."', '".$surname."');";
		$result = $conn->query($add);
		// success message
		echo '<p> Added Student: '.$forename.' '.$surname .' to database. </p>';
		echo '<p> Ran command: '.$add.'</p>';
		$conn->close();
	}
} else{
	// if forename and surname are not set or are blank print error message
	// disconnect from database
	$conn->close();
	// error message
	echo '<p>There was an error with your data!</p>';
}
?>
</body>
</html>