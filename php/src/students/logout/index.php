<!DOCTYPE html>
<html lang="en">
<head>
	<title>Choose First Letter Of Surname</title>
	<link rel="stylesheet" type="text/css" href="index.css">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
  	<a href="../.."><div style="display: inline-block;float: left;">Home</div></a>
	<h1>Choose the First Letter Of Surname</h1>
	<table cellspacing="5em" id='table' class='prettytable' style="max-height: 85%; height:100%; width:100%;"></table>
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
				cell.addEventListener('click',function(){window.location.href='studentlist.php?letter='+cellData;});
				row.appendChild(cell);
			});
			table.appendChild(row);
		});
	}
	var width=document.body.offsetWidth;
	var height=document.body.offsetHeight;
	//changemind var mod=Math.ceil(width/200); //to make it dynamic
	mod=6; //looks nice most of the time if is 6
	var html=[];
	alphabet = 'abcdefghijklmnopqrstuvwxyz'.split('');
	while(alphabet.length) html.push(alphabet.splice(0,mod));
	createTable(html);
</script>
