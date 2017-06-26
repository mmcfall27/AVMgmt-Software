<?php
	session_start();
	if($_SESSION['user_type'] == 0){
		header('location: ../login.php');
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Checkin</title>
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
			padding-bottom: 10px;
			padding-right: 10px;
		}
	</style>
</head>
<body onload='document.checkin.stock_num.focus()'>
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
			<h3><font color = "white">A/V Services<br><br>Equipment Checkin</font></h3>
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
							<li class='active'><a href='./checkin.php'>Checkin</a></li>
							<li><a href='../admin_tools/add_inv_reg.php'>Add Inventory</a></li>
							<li><a href='../reports/reports_admin.php'>Reports</a></li>
							<li><a href='../admin_tools/php_actions/mod_dbcode.php'>Database Administration</a></li>";
				}
				else if($_SESSION["user_type"] == 2){
					echo 	"<li><a href='../homepage.php'>Home</a></li>
							<li><a href='../checkout/checkout_choice.php'>Checkout</a></li>
							<li class='active'><a href='./checkin.php'>Checkin</a></li>
							<li><a href='../admin_tools/add_inv_reg.php'>Add Inventory</a></li>";
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
    <div class="col-sm-6">
      <div class="panel panel-primary">
        <div class="panel-heading text-center">Checkin</div>
        <div class="panel-body">
			<form name = 'checkin' action="./action/process_checkin.php" method='post'>
				<table align='center'>
					<tr>
						<td>
							Stock Number:
						</td>
						<td>
							<input type="number" name='stock_num' placeholder="Scan/Type Barcode" required>
						</td>
					</tr>
					<tr>
						<td>
							Date Returned:
						</td>
						<td>
							<?php
								$date = date("Y-m-d");
								echo "<input type='text' id='date' name='curr_date' value = '$date' readonly>";
							?>
						</td>
					</tr>
					<tr>
						<td>
							Maintenance:
						</td>
						<td>
							<select name='maint'>
								<option value='0'>No</option>
								<option value='1'>Yes</option>
							</select>
						</td>
					</tr>
					<tr>
						<td>
							Clerk Name:
						</td>
						<td>
							<?php
								$id = $_SESSION['user_id'];
								$query = "SELECT first_name, last_name FROM emp_info where user_id = \"$id\";";
								$result = mysqli_query($link, $query);
								$row = mysqli_fetch_assoc($result);
								$str = "<input type='text' name='clerk' value='".$row['first_name'].", ".$row['last_name']."' readonly>";
								echo $str;
							?>
						</td>
					</tr>
					<tr>
						<td colspan = '2'>
							<hr>
						</td>
					</tr>
					<tr align='center'>
						<td colspan='2'>
							<input type='submit' value='Process Checkin'>
						</td>
					</tr>
				</table>
			</form>
		</div>
      </div>
    </div>
    <div class="col-sm-6"> 
      <div class="panel panel-primary">
        <div class="panel-heading text-center">Checkin Procedure</div>
        <div class="panel-body">
		<ol>
			<li>Inspect item for damage.</li>
			<li>Make sure all pieces are accounted for.</li>
			<li>Scan or type in barcode information.</li>
			<li>Take appropriate action if item is late.</li>
			<li>Click process checkin to finalize item checkin process.</li>
		</ol>
		</div>
      </div>
    </div>
  </div><br>
</div>
</body>
</html>
