<?php
	error_reporting(1);
	$db = new mysqli("localhost", "rmannava", "rmannava2015", "rmannava");

	if ($db->connect_errno) {
		echo "Failed to connect to MySQL: (" . $db->connect_errno . ") " . $db->connect_error;
	}
?>
<!DOCTYPE HTML>
<!--
	Miniport by HTML5 UP
	html5up.net | @n33co
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
	<head>
		<title>Airport Reservation System</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<!--[if lte IE 8]><script src="assets/js/ie/html5shiv.js"></script><![endif]-->
		<link rel="stylesheet" href="assets/css/main.css" />
		<!--[if lte IE 8]><link rel="stylesheet" href="assets/css/ie8.css" /><![endif]-->
		<!--[if lte IE 9]><link rel="stylesheet" href="assets/css/ie9.css" /><![endif]-->
		<link rel="stylesheet" href="https://cdn.datatables.net/1.10.10/css/jquery.dataTables.min.css" />
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css"/>
	</head>
<body>

<div class="wrapper style2" id="usersDiv">
	<article id="work">
		<header>
			<h2><i class="fa fa-plane"></i> &nbsp;Airport Reservation System</h2>
			<p>Registered Users</p>
		</header>
	</article>
</div>
<div class="wrapper">

<table id="usersTable" class="display" cellspacing="0" width="80%">
        <thead>
            <tr>
                <th>UUID</th>
                <th>First</th>
                <th>Last</th>                
                <th>Email</th>  
				<th>Phone Number</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>UUID</th>
                <th>First</th>
                <th>Last</th>                
                <th>Email</th>  
				<th>Phone Number</th>
            </tr>
        </tfoot>
        <tbody>


<?php
//Php will poluate each table row
$query = "SELECT * FROM Users";
$result = $db->query($query);
if($result) {
	while ($row = $result->fetch_assoc()) {
		echo"<tr>";
		echo"<td>{$row['UUID']}</td>\n";
		echo"<td>{$row['First_Name']}</td>\n";
		echo"<td>{$row['Last_Name']}</td>\n";		
		echo"<td><i class=\"fa fa-envelope\"></i>&nbsp;&nbsp;{$row['Email_Address']}</td>\n";
		echo"<td><i class=\"fa fa-mobile\"></i>&nbsp;&nbsp;{$row['Phone_Number']}</td>\n";	
		/* echo"<td>";
		echo"<a href=\"{$row['picture']}\"><i class=\"fa fa-picture-o\"></i></a> ";
		echo"<a href=\"edit_user.php?UUID={$row['UUID']}\"><i class=\"fa fa-pencil-square-o\"></i></a>";
		echo"</td>\n"; */
		echo"</tr>";
	 }
}
?>
 
        </tbody>
</table>
</div>
</div>

		


		<!-- Scripts -->
			<script src="assets/js/jquery.min.js"></script>
			<script src="https://cdn.datatables.net/1.10.10/js/jquery.dataTables.min.js"></script>
			<!--[if lte IE 8]><script src="assets/js/ie/respond.min.js"></script><![endif]-->
			<script>
			$(function() {				

				$('#usersTable').DataTable();
				$('#coursesTable').DataTable();				
			});
			</script>

	</body>
</html>
