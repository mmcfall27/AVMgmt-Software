<?php
	session_start();
	if($_SESSION['user_type'] == 0){
		header('location: ./login.php');
	}
	if($_SESSION["dbadmin_code"] == 1){
		echo "<script type='text/javascript'>alert('Last database change succeeded.');</script>";
	}else if($_SESSION["dbadmin_code"] == 2){
		echo "<script type='text/javascript'>alert('Last database change failed.');</script>";
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Database Administration</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="../DataTables/datatables.min.css"/>
	<link href="../dist/css/select2.min.css" rel="stylesheet" />
	<script type="text/javascript" src="../DataTables/datatables.min.js"></script>
	<script type = 'text/javascript' src="../dist/js/select2.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			$(".admin_tools").select2();
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
		padding-right: 10px;
		padding-bottom: 10px;
	}
	option{
		padding-right: 10px;
		padding-bottom: 5px;
	}
	</style>
</head>
<body>
<!--this php section establishes a link to our database-->
<?php
    //Campus Hosted Virtual Server
	$link = mysqli_connect("localhost", "root", "Mtsu2017!", "avdatabase");
	
	//Local Wamp Server
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
			<img src="../img/avlogo.png" alt="HTML5 Icon" style = "float:left">
		</div>
		<div class="container text-center col-sm-4">
			<h3><font color = "white">A/V Services<br><br>Database Administration</font></h3>
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
				echo 	"<li><a href='./homepage.php'>Home</a></li>
						<li><a href='./checkout/checkout_choice.php'>Checkout</a></li>
						<li><a href='./checkin/checkin.php'>Checkin</a></li>
						<li><a href='./admin_tools/add_inv_reg.php'>Add Inventory</a></li>
						<li><a href='./reports/reports_admin.php'>Reports</a></li>
						<li class='active'><a href='./admin_tools/php_actions/mod_dbcode.php'>Database Administration</a></li>";
			}
		?>
      </ul>
	  <ul class="nav navbar-nav navbar-right">
			<li><a href="./login.php"><span class="glyphicon glyphicon-log-out"></span> Log Out</a></li>
		</ul>
    </div>
  </div>
</nav>
<div class="container">    
  <div class="row">
    <div class="col-sm-6 col-sm-offset-3">
      <div class="panel panel-primary">
        <div class="panel-heading text-center">Administration Tool Selection</div>
        <div class="panel-body">
			<form method="post" action="./admin_tools/redirect.php">
				<table align = 'center'>
					<tr>
						<td>
							<select class="admin_tools" name = 'admin_tools'>
								<optgroup label = 'Equipment Kit Tools'>
									<option value = 'add_kit'>Add new kit</option>
									<option value = 'add_equip_kit'>Add equipment to kit</option>
									<option value = 'rmv_equip_kit'>Remove equipment from kit</option>
									<option value = 'delete_kit'>Delete kit</option>
								<optgroup label = 'Add Options'>
									<option value="add_employee">Add Employee</option>
									<option value="add_inv">Add Inventory</option>
									<option value="add_customer">Add Customer</option>
									<option value='add_broke_equip'>Add item to broken equipment table</option>
									<option value = 'add_dept'>Add Department</option>
								<optgroup label = 'Remove Options'>
									<option value="rmv_employee">Remove Employee</option>
									<option value="rmv_inv">Remove Inventory</option>
									<option value="rmv_customer">Remove Customer</option>
									<option value = 'remove_dept'>Remove Department</option>
									<option value='rmv_broke_equip'>Remove item from broken equipment table</option>
								<optgroup label = 'Modify equip_inv Table'>
									<option value = 'mod_equip_inv_in_maintenance'>Modify in_maintenance Column</option>
									<option value = 'mod_equip_inv_equip_name'>Modify equip_name Column</option>
									<option value = 'mod_equip_inv_model_num'>Modify model_num Column</option>
									<option value = 'mod_equip_inv_serial_num'>Modify serial_num Column</option>
									<option value="mod_equip_inv_mtsu_asset_num">Modify mtsu_asset_num Column</option>
									<option value="mod_equip_inv_date_received">Modify date_received Column</option>
									<option value="mod_equip_inv_equip_cost">Modify equip_cost Column</option>
									<option value="mod_equip_inv_manufacturer">Modify manufacturer Column</option>
									<option value="mod_equip_inv_total_activity">Modify total_activity Column</option>
								<optgroup label = 'Modify loans Table'>
									<option value = 'mod_loans_due_date'>Modify due_date Column</option>
								<optgroup label = 'Modify customers Table'>
									<option value = 'mod_customers_active'>Modify active Column</option>
								<optgroup label = 'Equipment Reservation'>
									<option value='add_reservation'>Reserve Equipment</option>
									<option value = 'cancel_reservation'>Cancel Equipment Reservation</option>
							</select>
						<td>
					</tr>
					<tr>
						<td>
							<hr>
						</td>
					</tr>
					<tr>
						<td align='center'>
							<input type="submit" value="Request Admin Tool">
						</td>
					</tr>
				</table>
			</form>
		</div>
      </div>
    </div>
  </div>
</div>
</body>
</html>
