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
	$broke = $_POST["broke_info"];

	//Insert maintenance Table Query
	$q1 = "INSERT INTO broken_equipment (broken_equip_stock_num, broken_how) values ($stock, '$broke');";
	if(!mysqli_query($link,$q1)){
		echo("Error description: " . mysqli_error($link));
		exit;
	}
	
	//Update equip_inv to reflect the stock number as being broken
	$q2 = "update equip_inv set broken = 'yes' where stock_num = $stock;";
	if(!mysqli_query($link,$q2)){
		echo("Error description: " . mysqli_error($link));
		exit;
	}
	
	//Redirect to checkin page
	$_SESSION["dbadmin_code"] = 1; //Success Code
	header("location: ../../database_admin.php"); 
?>