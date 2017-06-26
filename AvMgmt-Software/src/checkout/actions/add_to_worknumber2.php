<?php
	//Start Session
	session_start();
	
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
	
	//Variable Declarations
	$work = $_POST["work_num"];
	$stock = $_POST["stock_num"];
	$clerk = $_POST["clerk"];
	$curr_date = $_POST["curr_date"];
	$ret_date = $_POST["ret_date"];
	
	$_SESSION["work_number"] = $work;
	
	//Check if item is already marked as being checked out
	$q0 = "select checked_out, in_maintenance, broken, reserved from equip_inv where stock_num = $stock";
	if(!mysqli_query($link, $q0)){
		echo("Error description: " . mysqli_error($link));
		exit;
	}else{
		$result0 = mysqli_query($link, $q0);
		$q0_data = mysqli_fetch_array($result0);
		$checkedout = $q0_data["checked_out"];
		$inmaint = $q0_data["in_maintenance"];
		$broke = $q0_data["broken"];
		$reserved = $q0_data["reserved"];
	}
	
	if(($checkedout == 'yes') || ($inmaint == 1) || ($broke == 'yes') || ($reserved == 'yes')){
		if($checkedout == 'yes'){
			echo("Error description: Equipment is already marked as being checked out.");
		}
		if($inmaint == 1){
			echo("Error description: Equipment is marked as being in for maintenance.");
		}
		if($broke == 'yes'){
			echo("Error description: Equipment is marked as being broken.");
		}
		if($broke == 'yes'){
			echo("Error description: Equipment is marked as being broken.");
		}
		if($reserved == 'yes'){
			echo("Error description: Equipment is marked as being reserved.");
		}
		echo "<form action = '../checkout_choice.php' method = 'post'><input type = 'submit' value = 'Return to checkout system'></form>";
		exit;
	}else{
		//Fetch customer data by running first query
		$q1 = "select loans.acc_num, loans.cust_id, customers.name
			from loans
			inner join customers on customers.id=loans.cust_id
			where loans.work_num = $work;";
			
		$result1 = mysqli_query($link, $q1);
		$cust_data = mysqli_fetch_array($result1);
		$cust_name = $cust_data["name"];
		$cust_acct = $cust_data["acc_num"];
		$cust = $cust_data["cust_id"];
		
		//Insert New Loan Query
		$q2 = "insert into loans(work_num, stock_num, acc_num, cust_id, checkout_clerk, checkout_date, due_date) VALUES($work,$stock,\"$cust_acct\",$cust,\"$clerk\",\"$curr_date\",\"$ret_date\");";
		if(!mysqli_query($link,$q2)){
			echo("Error description: " . mysqli_error($link));
			exit;
		}
		
		//Retrieve newly created loan id
		$q3 = "select loan_id from loans where work_num = $work and stock_num = $stock";
		if(!mysqli_query($link, $q3)){
			echo("Error description: " . mysqli_error($link));
			exit;
		}else{
			$result2 = mysqli_query($link, $q3);
			$loan_data = mysqli_fetch_array($result2);
			$lid = $loan_data["loan_id"];
		}
		
		//Update Equipment Inventory Table Query
		$q4 = "UPDATE equip_inv SET equip_location = \"$cust_name\", last_loan_id = $lid, checked_out = 'yes', total_activity = total_activity + 1 WHERE stock_num=$stock;";
		if(!mysqli_query($link,$q4)){
			echo("Error description: " . mysqli_error($link));
			exit;
		}
		
		//Redirect to homepage
		header("location: ../checkout_form.php");
	}
?>
