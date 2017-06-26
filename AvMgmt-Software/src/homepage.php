<?php
	session_start();
	if($_SESSION['user_type'] == 0){
		header('location: ./login.php');
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<?php
		//$link = mysqli_connect("localhost", "root", "Mtsu2017!", "avdatabase");
		$link = mysqli_connect("localhost", "root", "Mtsu2017!", "avdatabase");

		if (!$link) {
			echo "Error: Unable to connect to MySQL." . PHP_EOL;
			echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
			echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
			exit;
		}
	?>
	<title>Homepage</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel='stylesheet' href='../fullcalendar/fullcalendar.css' />
	<link rel="stylesheet" type="text/css" href="../DataTables/datatables.min.css"/>
	<script type="text/javascript" src="../DataTables/datatables.min.js"></script>
	<script src='../js/moment.min.js'></script>
	<script src='../fullcalendar/fullcalendar.js'></script>
	<style>
		/* Remove the navbar's default rounded borders and increase the bottom margin */ 
		.navbar {
		margin-bottom: 50px;
		border-radius: 0;
		}

		/* Remove the jumbotron's default bottom margin */ 
		.jumbotron {
		background-color: #0066CC;
		margin-bottom: 0;
		}

		/* Add a gray background color and some padding to the footer */
		footer {
		background-color: #f2f2f2;
		}
	</style>
	<script>
		$(document).ready(function() {
			// page is now ready, initialize the calendar...
			$('#calendar').fullCalendar({
				// put your options and callbacks here
				header:{
					left: 'prev,next today',
					center: 'title',
					right: 'month,basicWeek,basicDay'
				},
				selectable: true,
				selectHelper: true,
				events: [
					<?php
						$q1 = "select first_name, last_name, emp_bday from emp_info";
						$result = mysqli_query($link, $q1);
						$echstr = "{title: '";
						while($row = mysqli_fetch_assoc($result)){
							$date = $row['emp_bday'];
							$date = ltrim($date, '0..9');
							$birthday = date('Y');
							$birthday.=$date;
							$echstr.= $row['first_name'].' '.$row['last_name'].' Birthday\',start: \''.$birthday.'\'},';
							echo $echstr;
							$echstr = "{title: '";
						}
					?>
				]
			})
		});
	</script>
</head>
<body>
	<div class="jumbotron">
		<div class='row'>
			<div class='container col-sm-3 col-sm-offset-1'>
				<img src="../img/avlogo.png" alt="HTML5 Icon" style = "float:left">
			</div>
			<div class="container text-center col-sm-4">
				<h3><font color = "white">A/V Services<br><br>Inventory Management System</font></h3>
			</div>
			<div class='container col-sm-3'>
				<img src="../img/mtsuwhite.png" alt="HTML5 Icon" style = "float:right">
			</div>
		</div>
	</div>
	<nav class="navbar navbar-inverse">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>                        
				</button>
			</div>
			<div class="collapse navbar-collapse" id="myNavbar">
				<ul class="nav navbar-nav">
					<?php
						if($_SESSION["user_type"] == 1){
							echo 	"<li class='active'><a href='./homepage.php'>Home</a></li>
									<li><a href='./checkout/checkout_choice.php'>Checkout</a></li>
									<li><a href='./checkin/checkin.php'>Checkin</a></li>
									<li><a href='./admin_tools/add_inv_reg.php'>Add Inventory</a></li>
									<li><a href='./reports/reports_admin.php'>Reports</a></li>
									<li><a href='./admin_tools/php_actions/mod_dbcode.php'>Database Administration</a></li>";
						}
						else if($_SESSION["user_type"] == 2){
							echo 	"<li class='active'><a href='./homepage.php'>Home</a></li>
									<li><a href='./checkout/checkout_choice.php'>Checkout</a></li>
									<li><a href='./checkin/checkin.php'>Checkin</a></li>
									<li><a href='./admin_tools/add_inv_reg.php'>Add Inventory</a></li>";
						}
					?>
				</ul>
				<ul class="nav navbar-nav navbar-right">
					<li><a href="./logout.php"><span class="glyphicon glyphicon-log-out"></span>  Log Out</a></li>
				</ul>
			</div>
		</div>
	</nav>
	<div class='container col-sm-10 col-sm-offset-1' id='calendar'>
	</div>
	<footer class="navbar-default navbar-fixed-bottom">
		<div class = "container text-center">
			<a href="http://cem.mtsu.edu/main-staff-directory"><font color="black" size='4'>Click to navigate to the center for educational media's staff directory for contact information.</font></a>
		</div>
	</footer>
</body>
</html>
