<?php 
require '../../dbconnect.php';
if (isset($_GET['name']) && $_GET['name']!='') {
	$name = mysqli_real_escape_string($conn,$_GET['name']);
	$sql="SELECT * FROM `students` WHERE concat(forename,' ',surname) LIKE '".$name."'";
	$result = $conn->query($sql);
	if($result->num_rows>1){
		echo "<br><br>There was an error!<br/>";
		$conn->close();
	} else {
		$StudentID=array();
		$Forenames = array();
		$Surnames = array();
		while ($row = mysqli_fetch_assoc($result)) {
			array_push($StudentID, $row['StudentID']);
			array_push($Forenames, $row['Forename']);
			array_push($Surnames, $row['Surname']);
		}
		$StudentID = implode(',', $StudentID);
		$Forenames = implode(',',$Forenames);
		$Surnames  = implode(',',$Surnames);
		$now = date("Y-m-d H:i:s"); 
		$sql="INSERT INTO `register` (`RegisterID`, `InOrOut`, `Time`, `StudentID`) VALUES (NULL, b'1', NOW(), '".$StudentID."')";
		$conn->query($sql);
		$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Logged In</title>
	<link rel="stylesheet" type="text/css" href="index.css">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
	<a href="../.."><div style="display: inline-block;float: left;">Home</div></a>
	<table cellspacing="30em" id='table' class='prettytable' style="max-height: 99%; height:100%; width:100%;"><tr><td>You have been logged in<br><br>Redirecting you in 2 seconds...</td></tr></table>
</body>
</html>
<script type="text/javascript">
	setTimeout(function () {
	window.location.href = "../.."; 
	}, 2000); 
</script>
<?php
	}
} else {
echo "<br><br>There was an error!<br/>";
}
?>
