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
// if the student name is set and not empty
if (isset($_GET['student']) && $_GET['student']!="") {
	// escape student variable
	$student = mysqli_real_escape_string($conn,$_GET['student']);
	// form sql to get all occurances where the student attended class
	$sql="SELECT DATE_FORMAT(Time,'%W %D %M %Y') FROM `register` WHERE StudentID=$student";
	$result = $conn->query($sql);
	// if is no data from this specific student tell the user the student has never been in
	if($result->num_rows==0){
		echo "<br>This student has never been in!<br/>";
		$conn->close();
	// store in the variable arrayDates all the days for which the student attended
	} else {
		$arrayDates= array();
		while ($row = mysqli_fetch_assoc($result)) {
			array_push($arrayDates, $row["DATE_FORMAT(Time,'%W %D %M %Y')"]);
		}
		// remove duplicate dates
		$arrayDates = array_unique($arrayDates);
?>
<!-- html boilerplate -->
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Report for 
		<?php echo mysqli_fetch_assoc($conn->query("SELECT CONCAT(Forename,' ',Surname) from `students` WHERE StudentID=".$student))["CONCAT(Forename,' ',Surname)"]?>
	</title>
	<link rel="stylesheet" type="text/css" href="index.css">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
	<!-- hyperlinks -->
	<a href="index.php"><div style="display: inline-block;float: left;">Admin Home</div></a>
	<a href="index.php?logout"><div style="display: inline-block;float: right;">Logout</div></a>
	<br>
	<a href="studentreport.php"><div style="display: inline-block;float: left;">Back</div></a>
	<br>
	
	<h1>
		<!-- heading showing the student name -->
		Report for <?php echo mysqli_fetch_assoc($conn->query("SELECT CONCAT(Forename,' ',Surname) from `students` WHERE StudentID=".$student))["CONCAT(Forename,' ',Surname)"]?>
	</h1>

<?php
		// javascript create table function
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
		// for each date the student attended class - single date is $onedate
		foreach ($arrayDates as $onedate) {
			// init variables
			$RegisterID = array();
			$InOrOut = array();
			$Time = array();
			// form sql to get all rows a particular day $onedate
			$sql="SELECT RegisterID,InOrOut,DATE_FORMAT(Time,'%r'),StudentID FROM `register` WHERE StudentID=$student AND DATE_FORMAT(Time,'%W %D %M %Y')='$onedate'";
			// store in arrays
			$result = $conn->query($sql);
			while ($row = mysqli_fetch_assoc($result)) {
				array_push($RegisterID, $row["RegisterID"]);
				array_push($InOrOut, $row['InOrOut']);
				array_push($Time, $row["DATE_FORMAT(Time,'%r')"]);
			}
			// convert to strings
			$RegisterID = implode(',', $RegisterID);
			$InOrOut = implode(',', $InOrOut);
			$Time = implode(',', $Time);
			// print the date as a heading
			echo "<h3>".$onedate."</h3>";
			// Split arraytime by commas 
			$arrayTime=explode(',', $Time);
			// if there are exactly two rows for a given day then work out the difference in time 
			if($result->num_rows==2){
				for ($i=0; $i < count($arrayTime); $i++) { 
					$arrayTime[$i] = strtotime($arrayTime[$i]);
				}
				$tempvar=$arrayTime[1]-$arrayTime[0];
				// print session length
				echo 'Session Length: '.date('H.i.s',$tempvar);
			}
			// make a new table
			echo "<table cellspacing='10em' id='$onedate' class='prettytable'></table>";
			// javascript to make a pretty table with all the dates
			echo "<script>

					table=[('$RegisterID').split(','),('$InOrOut').split(','),('$Time').split(',')];
					for (var i = 0; i < table[0].length; i++) {
						table[1][i] == 0 ? table[1][i]='Out' : table[1][i]='In'
					}
					table=table[0].map((col, i) => table.map(row => row[i]));
					createTable(table,'$onedate')

				</script>";
		}
echo "
</body>
</html>";

	}
// if the variable is not set return error
} else {
	echo 'There was an error!';
}
?>
