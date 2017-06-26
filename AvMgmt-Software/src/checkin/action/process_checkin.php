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
	$stock = $_POST["stock_num"];
	$clerk = $_POST["clerk"];
	$curr_date = $_POST["curr_date"];
	$maint = $_POST["maint"];
	
	//Session Variables
	$_SESSION["stock_number"] = $stock;
	
	//Find out the work number and customer id and assign them to session variables
	$qloaninfo = "select work_num, cust_id from loans where stock_num = $stock and returned = 'no';";
	if(!mysqli_query($link, $qloaninfo)){
		echo("Error description: " . mysqli_error($link));
		echo "<form action = '../checkin.php' method = 'post'><input type = 'submit' value = 'Return to checkin system'></form>";
		exit;
	}
	$result = mysqli_query($link, $qloaninfo);
	$row = mysqli_fetch_array($result);
	$_SESSION["work_number"] = $row["work_num"];
	$_SESSION["customer_id"] = $row["cust_id"];
	
	//Check if stock number is in the database
	$qfind = "select stock_num from equip_inv where stock_num = $stock;";
	if(!mysqli_query($link, $qfind)){
		echo("Error description: " . mysqli_error($link));
		echo "<form action = '../checkin.php' method = 'post'><input type = 'submit' value = 'Return to checkin system'></form>";
		exit;
	}
	$result = mysqli_query($link, $qfind);
	if(mysqli_num_rows($result) == 0){
		echo("Error description: Stock Number does not exist in the database.");
		echo "<form action = '../checkin.php' method = 'post'><input type = 'submit' value = 'Return to checkin system'></form>";
		exit;
	}
	
	//Check to see if item being checked in is part of a kit
	$qkit = "select kit_part from equip_inv where stock_num = $stock;";
	if(!mysqli_query($link, $qfind)){
		echo("Error description: " . mysqli_error($link));
		echo "<form action = '../checkin.php' method = 'post'><input type = 'submit' value = 'Return to checkin system'></form>";
		exit;
	}
	$result = mysqli_query($link, $qkit);
	$row = mysqli_fetch_assoc($result);
	$kp = $row["kit_part"];
	
	if($kp == 'yes'){ //this is so that a kit part doesnt have its location changed from being part of a kit
		//Update equip_inv Table Query
		$q1 = "UPDATE equip_inv SET in_maintenance = $maint, checked_out = 'no' WHERE stock_num = $stock;";
		if(!mysqli_query($link,$q1)){
			echo("Error description: " . mysqli_error($link));
			echo "<form action = '../checkin.php' method = 'post'><input type = 'submit' value = 'Return to checkin system'></form>";
			exit;
		}
		
		//Update loans Table Query
		$q2 = "UPDATE loans SET checkin_clerk = '$clerk', returned = 'yes', date_returned = '$curr_date' WHERE stock_num = $stock;";
		if(!mysqli_query($link,$q2)){
			echo("Error description: " . mysqli_error($link));
			echo "<form action = '../checkin.php' method = 'post'><input type = 'submit' value = 'Return to checkin system'></form>";
			exit;
		}
		
		//Redirect
		if($maint == '0'){
			header("location: ../checkin_form.php"); //if no maint is required go to the checkin page
		}else{
			header("location: ../maint_req.php"); //if maint is required go to the maint required page
		}
	}else{ //this handles anything that isnt part of a kit so the equip location gets changed from being with the customer to the shop
		//Update equip_inv Table Query
		$q1 = "UPDATE equip_inv SET equip_location = 'shelf', in_maintenance = $maint, checked_out = 'no' WHERE stock_num = $stock;";
		if(!mysqli_query($link,$q1)){
			echo("Error description: " . mysqli_error($link));
			echo "<form action = '../checkin.php' method = 'post'><input type = 'submit' value = 'Return to checkin system'></form>";
			exit;
		}
		
		//Update loans Table Query
		$q2 = "UPDATE loans SET checkin_clerk = '$clerk', returned = 'yes', date_returned = '$curr_date' WHERE stock_num = $stock;";
		if(!mysqli_query($link,$q2)){
			echo("Error description: " . mysqli_error($link));
			echo "<form action = '../checkin.php' method = 'post'><input type = 'submit' value = 'Return to checkin system'></form>";
			exit;
		}
		
		//Redirect
		if($maint == '0'){
			header("location: ../checkin_form.php"); //if no maint is required go to the checkin page
		}else{
			header("location: ../maint_req.php"); //if maint is required go to the maint required page
		}
	}
?>