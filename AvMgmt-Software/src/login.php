<?php
	//Start Session
	session_start();
	$_SESSION["user_id"];
	$_SESSION["user_type"];
	$_SESSION["addcust_code"] = 0;
	$_SESSION["dbadmin_code"] = 0;
	$_SESSION["checkout_code"] = 0;
	$_SESSION["work_number"];
	$_SESSION["stock_number"];
	$_SESSION["customer_id"];
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>User Login</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="../DataTables/datatables.min.css"/>
	<script type="text/javascript" src="../DataTables/datatables.min.js"></script>
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
		padding-right: 20px;
	}
	</style>
</head>
<body onload="document.login.user_id.focus()">
<div class="jumbotron">
	<div class='row'>
		<div class='container col-sm-3 col-sm-offset-1'>
			<img src="../img/avlogo.png" alt="HTML5 Icon" style = "float:left">
		</div>
		<div class="container text-center col-sm-4">
			<h3><font color = "white">A/V Services<br><br>Login Page</font></h3>
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
      </ul>
    </div>
  </div>
</nav>
<div class="container">    
  <div class="row">
    <div class="col-sm-6 col-sm-offset-3">
      <div class="panel panel-primary">
        <div class="panel-heading text-center">User Login</div>
        <div class="panel-body" align='center'>
			<form name='login' action="./logincheck.php" method="post">
				<?php
					if($_SESSION["user_type"] == 9){
						echo	"<div>
									<p>Incorrect User ID or Password<br>Please try again.</p>
								</div>";
					}
				?>
				<table class = "login_table">
					<tr>
						<td align="right">
							User ID:
						</td>
						<td>
							<input type="text" name="user_id" size = "25">
						</td>
					</tr>
					<tr>
						<td align="right">
							Password:
						</td>
						<td>
							<input type = "password" name = "pword" size = "25">
						</td>
					</tr>
					<tr>
						<td colspan='2'>
							<hr>
						</td>
					</tr>
					<tr align='center'>
						<td colspan='2'>
							<input type="submit" value="Login">&nbsp <input type="reset" value='Reset Form' onclick = "document.login.user_id.focus()">
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
