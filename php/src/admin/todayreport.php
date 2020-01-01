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
<!-- html boilerplate code -->
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Today's Report</title>
	<link rel="stylesheet" type="text/css" href="index.css">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
	<a href="index.php"><div style="display: inline-block;float: left;">Admin Home</div></a>
	<a href="index.php?logout"><div style="display: inline-block;float: right;">Logout</div></a>
	<br>
	<h1>Today's Report</h1>
<?php 
// define createtable function to create pretty tables
echo "<script>
function createTable(tableData,tableName) {
	var table = document.getElementById(tableName);
	tableData.forEach(function(rowData) {
		var row = document.createElement('tr');
		rowData.forEach(function(cellData) {
			var cell = document.createElement('td');
			cell.appendChild(document.createTextNode(cellData));
			row.appendChild(cell);
		});
		table.appendChild(row);
	});
}
</script>";
// connect to database
require '../dbconnect.php';
// print today's date
echo "<h2>".date('l jS M Y')."</h2>";
// define $today as date variable with today's date
$today = date("Y-m-d"); 
// form sql to get all students' forenames and surnames who attended class on the date $today
$sql="SELECT CONCAT(Forename,' ',Surname) FROM `register` JOIN `students` ON students.StudentID=register.StudentID WHERE CONVERT(Time,DATE)='$today'";
$result = $conn->query($sql);
// if there were no students, end connection
if($result->num_rows==0){
	echo "<br>No Data<br/>";
	$conn->close();
} else{ 
	// otherwise make an array of names of students who attended class today
	$Name = array();
	while ($row = mysqli_fetch_assoc($result)) {
		array_push($Name, $row["CONCAT(Forename,' ',Surname)"]);
	}

	//remove duplicates 
	$uniqueNames = array_unique($Name);
	// for each student who attended class today
	foreach ($uniqueNames as $onename) {
		// declare variables
		$RegisterID = array();
		$InOrOut = array();
		$Time = array();
		// form sql to get all occurances of current student's attendance today
		$sql="SELECT RegisterID,InOrOut,DATE_FORMAT(Time,'%r') FROM `register` JOIN `students` ON students.StudentID=register.StudentID WHERE CONVERT(Time,DATE)='$today' AND CONCAT(Forename,' ',Surname)='$onename'";
		$result = $conn->query($sql);
		// store values in array then string
		while ($row = mysqli_fetch_assoc($result)) {
			array_push($RegisterID, $row["RegisterID"]);
			array_push($InOrOut, $row['InOrOut']);
			array_push($Time, $row["DATE_FORMAT(Time,'%r')"]);
		}
		$RegisterID = implode(',', $RegisterID);
		$InOrOut = implode(',', $InOrOut);
		$Time = implode(',', $Time);
		// print student's name
		echo "<h3>".$onename."</h3>";
		// split time by commas to string
		$arrayTime=explode(',', $Time);
		// if the student has 2 entries today calculate time student was in for
		if($result->num_rows==2){
			for ($i=0; $i < count($arrayTime); $i++) { 
				$arrayTime[$i] = strtotime($arrayTime[$i]);
			}
			$tempvar=$arrayTime[1]-$arrayTime[0];
			// print session length
			echo 'Session Length: '.date('H.i.s',$tempvar);
		}
		// make new table
		echo "<table cellspacing='10em' id='$onename' class='prettytable'></table>";
		// javascript to insert data into pretty table
		echo "<script>

			table=[('$RegisterID').split(','),('$InOrOut').split(','),('$Time').split(',')];
			for (var i = 0; i < table[0].length; i++) {
				table[1][i] == 0 ? table[1][i]='Out' : table[1][i]='In'
			}
			table=table[0].map((col, i) => table.map(row => row[i]));
			createTable(table,'$onename')

		</script>";
		
	}
?>
</body>
</html>
<?php 
} 
?>
