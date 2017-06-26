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
	$equip_stock = $_POST["equip"];
	$kit_stock = $_POST["kit"];

	//insert equipment into equip_kits Table Query
	$q1 = "INSERT INTO equip_kits (kit_stock_num, part_stock_num) VALUES ($kit_stock, $equip_stock);";
	if(!mysqli_query($link,$q1)){
		echo("Error description: " . mysqli_error($link));
		exit;
	}
	
	//Update equip_inv to reflect the stock number as being part of a kit
	$q2 = "update equip_inv set kit_part = 'yes' where stock_num = $equip_stock;";
	if(!mysqli_query($link,$q2)){
		echo("Error description: " . mysqli_error($link));
		exit;
	}
	
	//Redirect to checkin page
	$_SESSION["dbadmin_code"] = 1; //Success Code
	header("location: ../../database_admin.php"); 
?>