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
<!-- html boilerplate -->
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Custom Report</title>
	<link rel="stylesheet" type="text/css" href="index.css">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
	<a href="index.php"><div style="display: inline-block;float: left;">Admin Home</div></a>
	<a href="index.php?logout"><div style="display: inline-block;float: right;">Logout</div></a>
	<br>
	<h1>Custom Report</h1>

<?php 
// javascript function to create pretty tables
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
// if the date is set and not empty
if (isset($_GET['date']) && $_GET['date']!='') {
	// escape date and store in variable
	$userday = mysqli_real_escape_string($conn,$_GET['date']);
	// convert the string to a php time variable
	$tempvar=strtotime($userday);
	// print user chosen date as heading formatted with day date month and year
	echo "<h2>".date('l jS M Y',$tempvar)."</h2>";
	// remove variable
	unset($tempvar);
	// form sql to get all students' forenames and surnames who attended class on given date
	$sql="SELECT CONCAT(Forename,' ',Surname) FROM `register` JOIN `students` ON students.StudentID=register.StudentID WHERE CONVERT(Time,DATE)='$userday'";
	$result = $conn->query($sql);
	// echo out a form in which the user can enter another date
	echo "
	<form>
		<input type='date' name='date' value='$userday'>
		<input type='submit'>
	</form>";
	// if there were no students, end connection
	if($result->num_rows==0){
		echo "<br>No Data<br/>";
		$conn->close();
	} else{ 
		// otherwise make an array of names of students who attended class on given date
		$Name = array();
		while ($row = mysqli_fetch_assoc($result)) {
			array_push($Name, $row["CONCAT(Forename,' ',Surname)"]);
		}
		//remove duplicates 
		$uniqueNames = array_unique($Name);
		// for each student who attended class on given date
		foreach ($uniqueNames as $onename) {
			// declare variables
			$RegisterID = array();
			$InOrOut = array();
			$Time = array();
			// form sql to get all occurances of current student's attendance on given date
			$sql="SELECT RegisterID,InOrOut,DATE_FORMAT(Time,'%r') FROM `register` JOIN `students` ON students.StudentID=register.StudentID WHERE CONVERT(Time,DATE)='$userday' AND CONCAT(Forename,' ',Surname)='$onename'";
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
			echo "<h3>$onename</h3>";
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
	}
echo "
	</body>
	</html>
	";
} else{
	// print form to enter date if the user has not already chosen a date
	echo "
	<form>
		<input type='date' name='date'>
		<input type='submit'>
	</form>
	";
}
