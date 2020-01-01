<?php 
session_start(); 

define('DS',  TRUE); // used to protect includes
define('USERNAME', $_SESSION['username']);
define('SELF',  $_SERVER['PHP_SELF'] );

if (!USERNAME or isset($_GET['logout']))
	include('login.php');

// everything below will show after correct login 
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Secure Admin Panel</title>
	<link rel="stylesheet" type="text/css" href="index.css">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
	<a href="index.php"><div style="display: inline-block;float: left;">Admin Home</div></a>
	<a href="index.php?logout"><div style="display: inline-block;float: right;">Logout</div></a>
	<br>
	<h1>Secure Admin Panel</h1>
	<ul>
		<li><a href="addstudent.php">Add a Student</a></li>
		<li><a href="studentreport.php">Get a Student's Report</a></li>
		<li><a href="todayreport.php">Get Today's Report</a></li>
		<li><a href="dayreport.php">Get a Custom Day's Report</a></li>
	</ul>
</body>
</html>
