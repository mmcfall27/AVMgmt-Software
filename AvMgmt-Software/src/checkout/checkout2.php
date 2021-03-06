<?php
	session_start();
	if($_SESSION['user_type'] == 0){
		header('location: ../login.php');
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Checkout</title>
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
	td{
		padding-bottom: 10px;
		padding-right: 10px;
	}
	option{
		padding-bottom: 10px;
	}
	.DTTT_button{ 
		margin-right: 10px 
	}
  </style>
</head>
<body onload = 'document.check_out.cust_id.focus()'>
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
			<h3><font color = "white">A/V Services<br><br>Equipment Checkout</font></h3>
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
							<li class='active'><a href='./checkout_choice.php'>Checkout</a></li>
							<li><a href='../checkin/checkin.php'>Checkin</a></li>
							<li><a href='../admin_tools/add_inv_reg.php'>Add Inventory</a></li>
							<li><a href='../reports/reports_admin.php'>Reports</a></li>
							<li><a href='../admin_tools/php_actions/mod_dbcode.php'>Database Administration</a></li>";
				}
				else if($_SESSION["user_type"] == 2){
					echo 	"<li><a href='../homepage.php'>Home</a></li>
							<li class='active'><a href='./checkout_choice.php'>Checkout</a></li>
							<li><a href='../checkin/checkin.php'>Checkin</a></li>
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
	<div class="row" align='center'>
		<div class="col-sm-12">
			<div class="panel panel-primary">
				<div class="panel-heading text-center">Checkout Step 2</div>
				<div class="panel-body">
					<table id='customers' class='table col-sm-12'>
					   <?php
							$name = $_POST["lname"];
							$name = $name."%";
							$query = "SELECT id, name, department, acc_num, phone, email FROM customers where name like \"$name\" AND active = 'yes';";

							echo "<script type='text/javascript'>
									var data_set = [
									";
							
							$result = mysqli_query($link, $query);
							while($row = mysqli_fetch_assoc($result))
							{
								echo "['".htmlspecialchars($row['id'],ENT_QUOTES)."', '"
									 .htmlspecialchars($row['name'],ENT_QUOTES)."', '"
									 .htmlspecialchars($row['department'],ENT_QUOTES)."', '"
									 .htmlspecialchars($row['acc_num'],ENT_QUOTES)."', '"
									 .htmlspecialchars($row['phone'],ENT_QUOTES)."', '"
									 .htmlspecialchars($row['email'],ENT_QUOTES)."'],";
							};
							
							echo   "];
									
									$(document).ready(function() {
										$('#customers').DataTable( {
											data: data_set,
											columns: [
												{ title: 'Customer ID' },
												{ title: 'Customer Name' },
												{ title: 'Department' },
												{ title: 'Account Number' },
												{ title: 'Phone Number' },
												{ title: 'Email' }
											],
											dom: 'frtip',
											select: true,
											paging: false,
											scrollY: '250px',
											scrollCollapse: true
										 } );
									 } );  
									 
								  </script>";
						?> 
					</table>
					<hr>
					<form name = 'check_out' action='./checkout3.php' method='post'>
						<table>
							<tr>
								<td>
									Type Customer ID
								</td>
								<td>
									<input type='number' name='cust_id' align='right'>
								</td>
								<td>
									<input type='submit' value = 'Next Step'>
								</td>
							</tr>
						</table>
					</form>
					<hr>
					<form action = "./actions/modvar.php" method = "post">
						<input type = 'submit' value = 'Add new customer.'>
					</form>
				</div>
			</div>
		</div>
	</div><br>
</div>
</body>
</html>
