<?php
	session_start();
	if($_SESSION['user_type'] == 0){
		header('location: ../login.php');
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Remove Inventory</title>
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
  </style>
</head>
<body onload = 'document.form1.stock_num.focus()'>
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
			<h3><font color = "white">A/V Services<br><br>Remove Inventory Form</font></h3>
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
			<li><a href="../logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
		</ul>
    </div>
  </div>
</nav>
<div class="container">    
  <div class="row">
    <div class="col-sm-6 col-sm-offset-3">
      <div class="panel panel-primary">
        <div class="panel-heading text-center">Remove Inventory</div>
        <div class="panel-body">
			<form name = 'form1' action="./php_actions/rmvinv.php" method="post">
				<table name="rmvinv" align='center'>
					<tr>
						<td colspan = '2'>
							Please scan the barcode or type the number on the barcode label.
						</td>
					</tr>
					<tr>
						<td>
							<input type="number" id='stock_num' name="stock_num" placeholder = 'Barcode Number' required>
						</td>
						<td align = 'right'>
							<input type="submit" value="Remove Inventory">
						</td>
					</tr>
					<tr>
						<td colspan = '2'>
							<hr>
						</td>
					</tr>
					<tr>
						<td colspan = '2' align = 'center'>
							<input type="reset" value="Reset Form" onclick = 'document.form1.stock_num.focus()'>
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
