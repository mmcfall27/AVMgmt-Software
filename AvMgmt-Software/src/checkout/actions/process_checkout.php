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
	$cust = $_POST["cust_id"];
	$stock = $_POST["stock_num"];
	$clerk = $_POST["clerk"];
	$curr_date = $_POST["curr_date"];
	$ret_date = $_POST["ret_date"];
	
	//Session Variables
	$_SESSION["work_number"] = $work;
	$_SESSION["customer_id"] = $cust;
	
	//Check if stock number is in the database
	$qfind = "select stock_num from equip_inv where stock_num = $stock;";
	if(!mysqli_query($link, $qfind)){
		echo("Error description: " . mysqli_error($link));
		echo "<form action = '../checkout_choice.php' method = 'post'><input type = 'submit' value = 'Return to checkout system'></form>";
		exit;
	}
	$result = mysqli_query($link, $qfind);
	if(mysqli_num_rows($result) == 0){
		echo("Error description: Stock Number does not exist in the database.");
		echo "<form action = '../checkout_choice.php' method = 'post'><input type = 'submit' value = 'Return to checkout system'></form>";
		exit;
	}
	
	//Check if item is already marked as being checked out/in maintenance/broken/reserved
	$q0 = "select checked_out, in_maintenance, broken, reserved, kit_master, kit_part from equip_inv where stock_num = $stock";
	if(!mysqli_query($link, $q0)){
		echo("Error description: " . mysqli_error($link));
		echo "<form action = '../checkout_choice.php' method = 'post'><input type = 'submit' value = 'Return to checkout system'></form>";
		exit;
	}else{
		$result0 = mysqli_query($link, $q0);
		$q0_data = mysqli_fetch_array($result0);
		$checkedout = $q0_data["checked_out"];
		$inmaint = $q0_data["in_maintenance"];
		$broke = $q0_data["broken"];
		$reserved = $q0_data["reserved"];
		$km = $q0_data["kit_master"];
		$kp = $q0_data["kit_part"];
	}
	
	if(($checkedout == 'yes') || ($inmaint == 1) || ($broke == 'yes') || ($reserved == 'yes') || ($kp == 'yes')){
		if($checkedout == 'yes'){
			echo("Error description: Equipment is already marked as being checked out.");
		}
		if($inmaint == 1){
			echo("Error description: Equipment is marked as being in for maintenance.");
		}
		if($broke == 'yes'){
			echo("Error description: Equipment is marked as being broken.");
		}
		if($reserved == 'yes'){
			echo("Error description: Equipment is marked as being reserved.");
		}
		if($kp == 'yes'){
			echo("Error description: Equipment is marked as being part of a kit.");
		}
		echo "<form action = '../checkout_choice.php' method = 'post'><input type = 'submit' value = 'Return to checkout system'></form>";
		exit;
	}else if($km == 'yes'){
		//Fetch customer data by running first query
		$q1 = "select name, acc_num from customers where id = $cust";
		$result1 = mysqli_query($link, $q1);
		$cust_data = mysqli_fetch_array($result1);
		
		//Assign variable with first query results
		$cust_name = $cust_data["name"];
		$cust_acct = $cust_data["acc_num"];
		
		//Insert Kit stock number and info into loans table
		$q2 = "insert into loans(work_num, stock_num, acc_num, cust_id, checkout_clerk, checkout_date, due_date) VALUES($work,$stock,\"$cust_acct\",$cust,\"$clerk\",\"$curr_date\",\"$ret_date\");";
		if(!mysqli_query($link,$q2)){
			echo("Error description: " . mysqli_error($link));
			echo "<form action = '../checkout_choice.php' method = 'post'><input type = 'submit' value = 'Return to checkout system'></form>";
			exit;
		}
		
		//Retrieve newly created loan id
		$q3 = "select loan_id from loans where work_num = $work and stock_num = $stock";
		if(!mysqli_query($link, $q3)){
			echo("Error description: " . mysqli_error($link));
			echo "<form action = '../checkout_choice.php' method = 'post'><input type = 'submit' value = 'Return to checkout system'></form>";
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
			echo "<form action = '../checkout_choice.php' method = 'post'><input type = 'submit' value = 'Return to checkout system'></form>";
			exit;
		}
		
		//Retrieve all stock numbers associated with that kit stock number
		$qkit = "select part_stock_num from equip_kits where kit_stock_num = $stock;";
		if(!mysqli_query($link,$qkit)){
			echo("Error description: " . mysqli_error($link));
			echo "<form action = '../checkout_choice.php' method = 'post'><input type = 'submit' value = 'Return to checkout system'></form>";
			exit;
		}
		$result = mysqli_query($link, $qkit);
		while($row = mysqli_fetch_assoc($result)){
			//Assign part stock number to a variable for insertion
			$part_stock = $row["part_stock_num"];
			
			//Insert each part into loans table
			$q2 = "insert into loans(work_num, stock_num, acc_num, cust_id, checkout_clerk, checkout_date, due_date) VALUES($work,$part_stock,\"$cust_acct\",$cust,\"$clerk\",\"$curr_date\",\"$ret_date\");";
			if(!mysqli_query($link,$q2)){
				echo("Error description: " . mysqli_error($link));
				echo "<form action = '../checkout_choice.php' method = 'post'><input type = 'submit' value = 'Return to checkout system'></form>";
				exit;
			}
			
			//Retrieve newly created loan id
			$q3 = "select loan_id from loans where work_num = $work and stock_num = $part_stock";
			if(!mysqli_query($link, $q3)){
				echo("Error description: " . mysqli_error($link));
				echo "<form action = '../checkout_choice.php' method = 'post'><input type = 'submit' value = 'Return to checkout system'></form>";
				exit;
			}else{
				$result2 = mysqli_query($link, $q3);
				$loan_data = mysqli_fetch_array($result2);
				$lid = $loan_data["loan_id"];
			}
			
			//Update Equipment Inventory Table Query
			$q4 = "UPDATE equip_inv SET last_loan_id = $lid, checked_out = 'yes', total_activity = total_activity + 1 WHERE stock_num=$part_stock;";
			if(!mysqli_query($link,$q4)){
				echo("Error description: " . mysqli_error($link));
				echo "<form action = '../checkout_choice.php' method = 'post'><input type = 'submit' value = 'Return to checkout system'></form>";
				exit;
			}
		}
		
		//Redirect to checkout form
		header("location: ../checkout_form.php");
		
	}else{
		//Fetch customer data by running first query
		$q1 = "select name, acc_num from customers where id = $cust";
		$result1 = mysqli_query($link, $q1);
		$cust_data = mysqli_fetch_array($result1);
		
		//Assign variable with first query results
		$cust_name = $cust_data["name"];
		$cust_acct = $cust_data["acc_num"];
		
		//Insert New Loan Query
		$q2 = "insert into loans(work_num, stock_num, acc_num, cust_id, checkout_clerk, checkout_date, due_date) VALUES($work,$stock,\"$cust_acct\",$cust,\"$clerk\",\"$curr_date\",\"$ret_date\");";
		if(!mysqli_query($link,$q2)){
			echo("Error description: " . mysqli_error($link));
			echo "<form action = '../checkout_choice.php' method = 'post'><input type = 'submit' value = 'Return to checkout system'></form>";
			exit;
		}
		
		//Retrieve newly created loan id
		$q3 = "select loan_id from loans where work_num = $work and stock_num = $stock";
		if(!mysqli_query($link, $q3)){
			echo("Error description: " . mysqli_error($link));
			echo "<form action = '../checkout_choice.php' method = 'post'><input type = 'submit' value = 'Return to checkout system'></form>";
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
			echo "<form action = '../checkout_choice.php' method = 'post'><input type = 'submit' value = 'Return to checkout system'></form>";
			exit;
		}
		
		//Redirect to checkout form
		header("location: ../checkout_form.php");
	}
?>
