<?php
require '../../dbconnect.php';
$letter = mysqli_real_escape_string($conn,$_GET['letter']);
$sql = "SELECT * FROM students WHERE Surname LIKE '".$letter."%'";
$result = $conn->query($sql);
$forenames = array();
$surnames = array();
while ($row = mysqli_fetch_assoc($result)) {
    array_push($forenames, $row['Forename']);
    array_push($surnames, $row['Surname']);
	}
$forenames  = implode(',',$forenames);
$surnames  = implode(',',$surnames);
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Surnames</title>
	<link rel="stylesheet" type="text/css" href="index.css">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
	<a href="../.."><div style="display: inline-block;float: left;">Home</div></a>
	<h1>Tap your name:</h1>
	<table cellspacing="10em" id='table' class='prettytable'></table>
</body>
</html>
<script type="text/javascript">
	function createTable(tableData) {
		var table = document.getElementById('table');
		tableData.forEach(function(rowData) {
			var row = document.createElement('tr');
			rowData.forEach(function(cellData) {
				var cell = document.createElement('td');
				cell.appendChild(document.createTextNode(cellData));
				cell.addEventListener('click',function(){window.location.href='studentlogout.php?name='+cellData;});
				row.appendChild(cell);
			});
			table.appendChild(row);
		});
	}
	var names=[], tempvar=[];
	var forenames=("<?php echo $forenames;?>".replace(/\s/g,'')).split(',');
	var surnames=("<?php echo $surnames;?>".replace(/\s/g,'')).split(',');
	for (var i = 0; i < forenames.length; i++) names[i]=forenames[i]+' '+surnames[i]
	while(names.length) tempvar.push(names.splice(0,2));
	for (var i = 0; i < tempvar.length; i++) if(tempvar[i]!=' ') names.push(tempvar[i]);
	console.log(forenames,surnames,names,tempvar)
	names.length > 0 ? createTable(names) :	document.write('No students');
</script>
