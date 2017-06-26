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
	$id = $_POST["cust_id"];
	$begin = $_POST["date_begin"]; 
	$end = $_POST["date_end"];

	//Insert reservations Table Query
	$q1 = "INSERT INTO reservations (stock_num, cust_id, date_begin, date_end) values ($stock, $id, '$begin', '$end');";
	if(!mysqli_query($link,$q1)){
		echo("Error description: " . mysqli_error($link));
		exit;
	}
	
	//Update equip_inv to reflect the stock number as being reserved
	$q2 = "update equip_inv set reserved = 'yes' where stock_num = $stock;";
	if(!mysqli_query($link,$q2)){
		echo("Error description: " . mysqli_error($link));
		exit;
	}
	
	//Redirect to checkin page
	$_SESSION["dbadmin_code"] = 1; //Success Code
	header("location: ../../database_admin.php"); 
?>