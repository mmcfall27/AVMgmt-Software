<?php
	session_start();
	if($_SESSION['user_type'] == 0){
		header('location: ../login.php');
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Remove Employee</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="../../DataTables/datatables.min.css"/>
	<link href="../../dist/css/select2.min.css" rel="stylesheet" />
	<script type="text/javascript" src="../../DataTables/datatables.min.js"></script>
	<script type = 'text/javascript' src="../../dist/js/select2.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			$(".user_id").select2();
		});
	</script>
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
		label{
			margin-bottom: 20px;
		}
		.sub{
			margin-right: 20px;
		}
		td{
			padding-bottom: 5px;
			padding-right: 5px;
		}
		select{
			width: 200px;
		}
	</style>
</head>
<body>
<!--this php section establishes a link to our database-->
<?php
	$link = mysqli_connect("localhost", "root", "Mtsu2017!", "avdatabase");
	//$link = mysqli_connect("localhost", "root", "", "avdatabase");

	if (!$link) {
		echo "Error: Unable to connect to MySQL." . PHP_EOL;
		echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
		echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
		exit;
	}
?>
<div class="jumbotron">
	<div class='row'>
		<div class='container col-sm-3 col-sm-offset-1'>
			<img src="../../img/avlogo.png" alt="HTML5 Icon" style = "float:left">
		</div>
		<div class="container text-center col-sm-4">
			<h3><font color = "white">A/V Services<br><br>Remove Employee Form</font></h3>
		</div>
		<div class='container col-sm-3'>
			<img src="../../img/mtsuwhite.png" alt="HTML5 Icon" style = "float:right">
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
					echo 	"<li><a href='../homepage.php'>Home</a></li>
							<li><a href='../checkout/checkout_choice.php'>Checkout</a></li>
							<li><a href='../checkin/checkin.php'>Checkin</a></li>
							<li><a href='./add_inv_reg.php'>Add Inventory</a></li>
							<li><a href='../reports/reports_admin.php'>Reports</a></li>
							<li class='active'><a href='./php_actions/mod_dbcode.php'>Database Administration</a></li>";
				}
			?>
		</ul>
		<ul class="nav navbar-nav navbar-right">
			<li><a href="../logout.php"><span class="glyphicon glyphicon-log-out"></span> Log Out</a></li>
		</ul>
    </div>
  </div>
</nav>
<div class="container">    
  <div class="row">
    <div class="col-sm-6 col-sm-offset-3">
      <div class="panel panel-primary">
        <div class="panel-heading text-center">Remove Employee</div>
        <div class="panel-body">
			<form action="./php_actions/rmvemp.php" method="post">
				<table name="rmvemp" align="center">
					<tr>
						<td>
							<?php
								$query = "SELECT first_name, last_name, user_id FROM emp_info;";
								$result = mysqli_query($link, $query);

								$select = "<select class = 'user_id' id='user_id' name='user_id'>";
								while($row = mysqli_fetch_assoc($result)){
									$select.='<option value='.$row['user_id'].'>'.$row['first_name'].' '.$row['last_name'].'</option>';
								}
								$select.= '</select>';
								echo $select;
							?>
						</td>
					</tr>
					<tr>
						<td>
							<hr>
						</td>
					</tr>
					<tr>
						<td align='center'>
							<input type="submit" value="Remove Employee">
						</td>
					</tr>
				</table>
			</form>
		</div>
      </div>
    </div>
  </div><br>
</div>
</body>
</html>
