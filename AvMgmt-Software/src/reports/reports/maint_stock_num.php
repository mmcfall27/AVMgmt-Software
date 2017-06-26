<?php
	session_start();
	if($_SESSION['user_type'] == 0){
		header('location: ../login.php');
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Maintenance History: Stock Number</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" href="../../../DataTables/datatables.min.css"/>
	<script type="text/javascript" src="../../../DataTables/datatables.min.js"></script>
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
		padding-right: 20px;
	}
	.myrow{
		padding-bottom: 20px;
	}
  </style>
</head>
<body onload = 'document.form1.kstock.focus()'>
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
			<img src="../../../img/avlogo.png" alt="HTML5 Icon" style = "float:left">
		</div>
		<div class="container text-center col-sm-4">
			<h3><font color = "white">A/V Services<br><br>Maintenance History: Stock Number</font></h3>
		</div>
		<div class='container col-sm-3'>
			<img src="../../../img/mtsuwhite.png" alt="HTML5 Icon" style = "float:right">
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
					echo 	"<li><a href='../../homepage.php'>Home</a></li>
							<li><a href='../../checkout/checkout_choice.php'>Checkout</a></li>
							<li><a href='../../checkin/checkin.php'>Checkin</a></li>
							<li><a href='../../admin_tools/add_inv_reg.php'>Add Inventory</a></li>
							<li class = 'active'><a href='../reports_admin.php'>Reports</a></li>
							<li><a href='../../admin_tools/php_actions/mod_dbcode.php'>Database Administration</a></li>";
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
			<li><a href="../../logout.php"><span class="glyphicon glyphicon-log-out"></span> Log Out</a></li>
		</ul>
    </div>
  </div>
</nav>
<div class="container">    
  <div class="row">
    <div class="col-sm-4">
      <div class="panel panel-primary">
        <div class="panel-heading text-center">Maintenance History: Stock Number</div>
        <div class="panel-body" align='center'>
			<form name = 'form1' action = './action/maint_stock_num_action.php' method = 'post'>
				<table>
					<tr>
						<td>
							Stock Number
						</td>
						<td>
							<input type = 'number' placeholder = 'Type/Scan barcode' name = 'kstock' required>
						</td>
					</tr>
					<tr><td colspan = '2'><hr></td></tr>
					<tr>
						<td colspan = '2' align = 'center'>
							<input type = 'submit'>
						</td>
					</tr>
				</table>
			</form>
		</div>
      </div>
    </div>
	<div class="col-sm-8">
      <div class="panel panel-primary">
        <div class="panel-heading text-center">Reference</div>
        <div class="panel-body">
			<table id='dept' class='table col-sm-12'>
				<?php
				$query = "SELECT maint_history.stock_num, equip_inv.equip_name
							FROM maint_history
							INNER JOIN equip_inv on equip_inv.stock_num = maint_history.stock_num;";

				echo "<script type='text/javascript'>
						var data_set = [
						";
				
				$result = mysqli_query($link, $query);
				while($row = mysqli_fetch_assoc($result))
				{
					echo "['".htmlspecialchars($row['stock_num'],ENT_QUOTES)."', '"
						 .htmlspecialchars($row['equip_name'],ENT_QUOTES)."'],";
				};
				echo   "];";
				
				echo	"$(document).ready(function() {
							$('#dept').DataTable( {
								data: data_set,
								columns: [
									{ title: 'Stock #' },
									{ title: 'Equip. Name' }
								],
								dom: 'frtip',
								paging: false,
								scrollY: '325px',
								scrollCollapse: true
							 } );
						 } );  
						 
					  </script>";
				?> 
			</table>
		</div>
      </div>
    </div>
  </div>
</div>
</body>
</html>
