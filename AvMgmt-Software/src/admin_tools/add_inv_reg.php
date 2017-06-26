<?php
	session_start();
	if($_SESSION['user_type'] == 0){
		header('location: ../login.php');
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Add Inventory</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="../../DataTables/datatables.min.css"/>
	<script type="text/javascript" src="../../DataTables/datatables.min.js"></script>
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
	.col-centered{
		float: none;
		margin: 0 auto;
	}
	td{
		padding-bottom: 5px;
		padding-right: 5px;
	}
	</style>
</head>
<body onload = 'document.addinv.equip_name.focus()'>
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
			<img src="../../img/avlogo.png" alt="HTML5 Icon" style = "float:left">
		</div>
		<div class="container text-center col-sm-4">
			<h3><font color = "white">A/V Services<br><br>Add Inventory Form</font></h3>
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
							<li class='active'><a href='./add_inv_reg.php'>Add Inventory</a></li>
							<li><a href='../reports/reports_admin.php'>Reports</a></li>
							<li><a href='./php_actions/mod_dbcode.php'>Database Administration</a></li>";
				}
				else if($_SESSION["user_type"] == 2){
					echo 	"<li><a href='../homepage.php'>Home</a></li>
							<li><a href='../checkout/checkout.php'>Checkout</a></li>
							<li><a href='../checkin/checkin.php'>Checkin</a></li>
							<li class='active'><a href='./add_inv_reg.php'>Add Inventory</a></li>";
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
    <div class="col-sm-6 col-centered">
      <div class="panel panel-primary">
        <div class="panel-heading text-center">Add Inventory</div>
        <div class="panel-body">
			<form name='addinv' action="./php_actions/addinvreg.php" method="post">
				<table name="addinv" align='center'>
					<tr>
						<td>
							Stock Number:
						</td>
						<td>
							<?php
								$stock_num = rand(pow(10, 4), pow(10, 5)-1);
								
								//Query to check if randomly generated stock number already exists and replace if need be
								$q1 = "select stock_num from equip_inv where stock_num = $stock_num";
								$result = mysqli_query($link, $q1);
								while(mysqli_num_rows($result)!=0){
									$stock_num = rand(pow(10, 4), pow(10, 5)-1);
									$result = mysqli_query($link, $q1);
								}
								//Output Work Number Input Block
								echo "<input type='number' name='stock_num' value='$stock_num' readonly>";
							?>
						</td>
					</tr>
					<tr>
						<td>
							Equipment Name:
						</td>
						<td>
							<input type="text" id='equip_name' name="equip_name" required>
						</td>
					</tr>
					<tr>
						<td>
							Model Number:
						</td>
						<td>
							<input type='text' name = 'model_num' placeholder = 'Model Number' required>
						</td>
					</tr>
					<tr>
						<td>
							Serial Number:
						</td>
						<td>
							<input type='text' name = 'serial_num' placeholder = 'Serial Number' required>
						</td>
					</tr>
					<tr>
						<td>
							MTSU Asset Number:
						</td>
						<td>
							<input type="number" id='mtsu_num' name="mtsu_num" placeholder='Use 0 if unknown' required>
						</td>
					</tr>
					<tr>
						<td>
							Storage Location:
						</td>
						<td>
							<input type='text' id='storage_loc' name='storage_loc' required>
						</td>
					</tr>
					<tr>
						<td>
							Date Received:
						</td>
						<td>
							<input type='date' id='date_received' name='date_received' required>
						</td>
					</tr>
					<tr>
						<td>
							Manufacturer:
						</td>
						<td>
							<input type='text' id='manufacturer' name='manufacturer' required>
						</td>
					</tr>
					<tr>
						<td>
							Equipment Cost:
						</td>
						<td>
							<input type='number' id='equip_cost' name='equip_cost' min='0' step='any' required>
						</td>
					</tr>
					<tr>
						<td colspan = '2'>
							<hr>
						</td>
					</tr>
					<tr>
						<td>
							<input type="submit" value="Add Inventory">
						</td>
						<td align = 'right'>
							<input type="reset" value="Reset Form" onclick = 'document.addinv.equip_name.focus()'>
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
