<?php
	session_start();
	if($_SESSION['user_type'] == 0){
		header('location: ../login.php');
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Reports</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="../../DataTables/datatables.min.css"/>
	<link href="../../dist/css/select2.min.css" rel="stylesheet" />
	<script type="text/javascript" src="../../DataTables/datatables.min.js"></script>
	<script type = 'text/javascript' src="../../dist/js/select2.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			$(".reports").select2();
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
	</style>
</head>
<body>
<div class="jumbotron">
	<div class='row'>
		<div class='container col-sm-3 col-sm-offset-1'>
			<img src="../../img/avlogo.png" alt="HTML5 Icon" style = "float:left">
		</div>
		<div class="container text-center col-sm-4">
			<h3><font color = "white">A/V Services<br><br>Reports</font></h3>
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
							<li><a href='../admin_tools/add_inv_reg.php'>Add Inventory</a></li>
							<li class='active'><a href='./reports_admin.php'>Reports</a></li>
							<li><a href='../admin_tools/php_actions/mod_dbcode.php'>Database Administration</a></li>";
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
        <div class="panel-heading text-center">Report Selection</div>
        <div class="panel-body" align='center'>
			<form action="redirect.php" method='post'>
				<table>
					<tr>
						<td>
							<select class = 'reports' name='report'>
								<optgroup label = 'Master Reports'>
									<option value='mast_inv_rep'>Master Equipment Inventory</option>
									<option value='mast_dept'>Master Departments List</option>
									<option value='mast_cust'>Master Customer List</option>
									<option value='mast_maint'>Master Equipment Maintenance</option>
									<option value='mast_broke_list'>Master Broken Equipment List</option>
									<option value='mast_kit_list'>Master Kit List</option>
								<optgroup label = 'Maintenance History'>
									<option value='mast_maint_history'>Master Report</option>
									<option value='maint_stock_num'>Maintenance: Stock Number</option>
								<optgroup label = 'Equipment Due'>
									<option value = 'coming_due_day'>Coming Due: Today</option>
									<option value = 'coming_due_month'>Coming Due: Month</option>
									<option value = 'coming_due_year'>Coming Due: Year</option>
									<option value = 'equip_overdue'>Equipment Overdue</option>
								<optgroup label = 'Total Checkouts'>
									<option value = 'total_checkouts_date_range'>Date Range</option>
									<option value = 'total_checkouts_date_range_and_dept'>Date Range & Acct Num</option>
									<option value = 'total_checkouts_date_range_and_cust'>Date Range & Customer</option>
								<optgroup label = 'Equipment Kits'>
									<option value = 'kit_equip_stock'>Kit Equipment: Kit Stock Number</option>
								<optgroup label = 'Check In/Out'>
									<option value = 'checkout_printout'>Checkout Form: Work Number</option>
									<option value = 'checkin_printout'>Checkin Form: Work Number</option>
								<optgroup label = 'Misc. Reports'>
									<option value = 'loan_work_number'>Loan Report: Work Number</option>
									<option value='birthday_rep'>Employee Birthdays</option>
									<option value='curr_loans'>Current Loans</option>
									<option value = 'available_equipment'>Available Equipment</option>
									
							</select>
						</td>
					</tr>
					<tr>
						<td>
							<hr>
						</td>
					</tr>
					<tr>
						<td align='center'>
							<input type='submit' value='Request Report'>
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
