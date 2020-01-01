<?php 
session_start(); 

define('DS',  TRUE); // used to protect includes
define('USERNAME', $_SESSION['username']);
define('SELF',  $_SERVER['PHP_SELF'] );

if (!USERNAME or isset($_GET['logout']))
	include('login.php');

// everything below will show after correct login 
?>
<!-- html boilerplate code -->
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Add a Student</title>
	<!-- link stylesheet and add viewport accesibility -->
	<link rel="stylesheet" type="text/css" href="index.css">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
	<!-- links to homepage and logout -->
	<a href="index.php"><div style="display: inline-block;float: left;">Admin Home</div></a>
	<a href="index.php?logout"><div style="display: inline-block;float: right;">Logout</div></a>
	<br>
	<!-- heading -->
	<h1>Add a Student</h1>
	<!-- form to add a student -->
	<form action="addstudent2.php" method="post">
		<!-- input forename and surname -->
		<p><label for="Forename">Forename:</label> <input type="text" id="Forename" name="Forename" value=""></p>
		<p><label for="Surname">Surname:</label> <input type="text" id="Surname" name="Surname" value=""></p>
		<!-- submit form button -->
		<p><input type="submit" name="submit"></p>
	</form>
</body>
</html>
