<?php 
// setup php session
session_start(); 

define('DS',  TRUE); // used to protect includes
define('USERNAME', $_SESSION['username']);
define('SELF',  $_SERVER['PHP_SELF'] );

if (!USERNAME or isset($_GET['logout']))
	include('login.php');

// everything below will show after correct login 
?>
<?php  
// connect to database
require '../dbconnect.php';
// get all students
$sql="SELECT * FROM `students`";
$result = $conn->query($sql);
$StudentID=array();
$Forenames = array();
$Surnames = array();
// store student id, forenames, surnames into php string variables
while ($row = mysqli_fetch_assoc($result)) {
	array_push($StudentID, $row['StudentID']);
	array_push($Forenames, $row['Forename']);
	array_push($Surnames, $row['Surname']);
}
$StudentID = implode(',', $StudentID);
$Forenames = implode(',',$Forenames);
$Surnames  = implode(',',$Surnames);
?>
<!-- html boilerplate -->
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Student Report</title>
	<link rel="stylesheet" type="text/css" href="index.css">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
	<!-- home and logout buttons -->
	<a href="index.php"><div style="display: inline-block;float: left;">Admin Home</div></a>
	<a href="index.php?logout"><div style="display: inline-block;float: right;">Logout</div></a>
	<br>
	<h1>Choose a Student</h1>
</body>
</html>

<script type="text/javascript">
	// store student id, forenames, surnames into javascript array variables from php string variables
	var studentid=("<?php echo $StudentID;?>".replace(/\s/g,'')).split(',');
	var forenames=("<?php echo $Forenames;?>".replace(/\s/g,'')).split(',');
	var surnames=("<?php echo $Surnames;?>".replace(/\s/g,'')).split(',');
	// javascript for loop to iterate through each student and list all student names
	for (var i = 0; i < studentid.length; i++) {
		document.write("<ul style='	line-height: 110%'>");
		document.write('<li>');
		document.write("<a href='studentreport2.php?student="+studentid[i]+"'>")
		document.write(studentid[i]+' - '+forenames[i]+' '+surnames[i]);
		document.write('</a>')
		document.write('</li>');
		document.write('</ul>');
	}
</script>
