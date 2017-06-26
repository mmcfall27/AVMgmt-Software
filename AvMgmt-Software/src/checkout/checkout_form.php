<?php
	session_start();
	if($_SESSION['user_type'] == 0){
		header('location: ../login.php');
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Equipment Checkout Form</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="../../DataTables/datatables.min.css"/>
	<script type="text/javascript" src="../../DataTables/datatables.min.js"></script>
	<style>
		@page{ 
			size: auto;  
			margin: 0mm; 
		}
		label{
			font-weight: normal;
		}
		label.logo{
			padding-top: 30px;
			font-size: 30px;
		}
		label.sig{
			padding-top: 75px;
			padding-left: 50px;
			font-size: 20px;
		}
		#print_button{
			padding-top: 50px;
		}
		.textarea1{
			min-width: 80%;
			max-width: 80%;
			min-height: 100px;
		}
	</style>
</head>
<body>
<!--this php section establishes a link to our database and collects the data for the form-->
<?php
	$link = mysqli_connect("localhost", "root", "Mtsu2017!", "avdatabase");
	//$link = mysqli_connect("localhost", "root", "", "avdatabase");

	if (!$link) {
		echo "Error: Unable to connect to MySQL." . PHP_EOL;
		echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
		echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
		exit;
	}
	$work = $_SESSION["work_number"];
	$query = "SELECT loans.work_num, loans.stock_num, loans.acc_num, loans.checkout_clerk, loans.checkout_date, loans.due_date, customers.name, departments.dept_name, equip_inv.equip_name FROM loans 
			INNER JOIN customers on loans.cust_id = customers.id
			INNER JOIN departments on loans.acc_num = departments.acc_num
			INNER JOIN equip_inv on loans.stock_num = equip_inv.stock_num
			where returned = 'no' and work_num = $work;";
			
	$result = mysqli_query($link, $query);
?>
<div class="container">    
	<div class = 'row'>
		<div class = 'col-sm-12' align = 'center'>
			<label class = 'logo'><b>Middle Tennessee State University<br>
			Audio/Visual Services<br>
			Equipment Loan</b></label>
		</div>
	</div>
	<hr>
	<div class="row">
		<div class = 'col-sm-12' align = 'center'>
			<?php
				echo "<table style = 'width:90%'>";
					echo "<tr>";
						echo "<th>Work #</th>";
						echo "<th>Stock #</th>";
						echo "<th>Equip. Name</th>";
						echo "<th>Cust. Name</th>";
						echo "<th>Acct. #</th>";
						echo "<th>Dept. Name</th>";
						echo "<th>Checkout Date</th>";
						echo "<th>Due Date</th>";
						echo "<th>Clerk</th>";
					echo "</tr>";
				while($row = mysqli_fetch_assoc($result)){
					echo "<tr>";
						echo "<td>".$row['work_num']."</td>";
						echo "<td>".$row['stock_num']."</td>";
						echo "<td>".$row['equip_name']."</td>";
						echo "<td>".$row['name']."</td>";
						echo "<td>".$row['acc_num']."</td>";
						echo "<td>".$row['dept_name']."</td>";
						echo "<td>".$row['checkout_date']."</td>";
						echo "<td>".$row['due_date']."</td>";
						echo "<td>".$row['checkout_clerk']."</td>";
					echo "</tr>";
				};
				echo "</table>";
			?> 
		</div>
		<div class = 'row'>
			<div class = 'col-sm-12' align = 'center'>
				<br><b>Notes</b>
			</div>
		</div>
		<div class = 'row'>
			<div class = 'col-sm-12' align = 'center'>
				<textarea class = 'textarea1' name = 'comments' placeholder = 'Type notes here...'></textarea>
			</div>
		</div>
		<div class = 'row'>
			<div class = 'col-sm-12' align = 'left'>
				<label class = 'sig'>Customer Signature:__________________________________________________________</label>
			</div>
		</div>
		<div class = 'row'>
			<div class = 'col-sm-12' align = 'center'>
				<b>***In the event of equipment damage/loss, the repair/replacement cost of the item will be charged to the account number used during the checkout process.***</b>
			</div>
		</div><br><br>
		<div class = 'row'>
			<div class = 'col-sm-4' align = 'center'>
				<form action = "./checkout_choice.php" class = 'hidden-print'>
					<input type = 'submit' value = 'Return to Checkout System'>
				</form>
			</div>
			<div class = 'col-sm-4' align = 'center'>
				<label class = 'hidden-print'><input type = 'button' value = 'Print Page' onclick = 'window.print()'></label>
			</div>
			<div class = 'col-sm-4' align = 'center'>
				<form action = "./add_another.php" class = 'hidden-print'>
					<input type = 'submit' value = 'Add another item to the work number.'>
				</form>
			</div>
		</div>
	</div>
</div>
</body>
</html>
