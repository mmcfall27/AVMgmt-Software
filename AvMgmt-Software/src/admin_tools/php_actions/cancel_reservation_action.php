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

	//delete reservation from reservations Table Query
	$q1 = "DELETE from reservations where stock_num = $stock;";
	if(!mysqli_query($link,$q1)){
		echo("Error description: " . mysqli_error($link));
		exit;
	}
	
	//Update equip_inv to reflect the stock number as being not reserved
	$q2 = "update equip_inv set reserved = 'no' where stock_num = $stock;";
	if(!mysqli_query($link,$q2)){
		echo("Error description: " . mysqli_error($link));
		exit;
	}
	
	//Redirect to checkin page
	$_SESSION["dbadmin_code"] = 1; //Success Code
	header("location: ../../database_admin.php"); 
?>