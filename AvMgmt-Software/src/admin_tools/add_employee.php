<?php
	session_start();
	if($_SESSION['user_type'] == 0){
		header('location: ../login.php');
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Add Employee</title>
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
		padding-bottom: 5px;
		padding-right: 5px;
	}
	select{
		width: 200px;
	}
  </style>
</head>
<body onload = 'document.form1.first_name.focus()'>
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
			<h3><font color = "white">A/V Services<br><br>Add Employee Form</font></h3>
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
			<li><a href="../homepage.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
		</ul>
    </div>
  </div>
</nav>
<div class="container">    
  <div class="row">
    <div class="col-sm-6 col-sm-offset-3">
      <div class="panel panel-primary">
        <div class="panel-heading text-center">Add Employee</div>
        <div class="panel-body" align = 'center'>
			<form name = 'form1' action="./php_actions/addemp.php" method="post">
				<table name="addemp">
					<tr>
						<td>
							First Name: 
						</td>
						<td>
							<input type="text" name="first_name" size = '25' required>
						</td>
					</tr>
					<tr>
						<td>
							Last Name: 
						</td>
						<td>
							<input type="text" name="last_name" size = '25' required>
						</td>
					</tr>
					<tr>
						<td>
							User Type: 
						</td>
						<td>
							<!--<select name="user_type">
								<option value = "1">Admin</option>
								<option value = "2">Regular</option>
							</select>-->
							Admin <input type = 'radio' name = 'user_type' value = '1'>
							Regular <input type = 'radio' name = 'user_type' value = '2'>
						</td>
					</tr>
					<tr>
						<td>
							User ID: 
						</td>
						<td>
							<input type="text" name="user_id" size = '25' required>
						</td>
					</tr>
					<tr>
						<td>
							Password: 
						</td>
						<td>
							<input type="password" name="user_pword" size = '25' required>
						</td>
					</tr>
					<tr>
						<td>
							Employee Birthday:
						</td>
						<td>
							<input type="date" id="bday" name='bday' required>
						</td>
					</tr>
					<tr>
						<td colspan='2'>
							<hr>
						</td>
					</tr>
					<tr>
						<td>
							<input type="submit" value="Add Employee">
						</td>
						<td align = 'right'>
							<input type="reset" value="Reset Form" onclick = 'document.form1.first_name.focus()'>
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