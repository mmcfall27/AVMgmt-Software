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
	$maint = $_POST["maint_info"];

	//Insert maintenance Table Query
	$q1 = "INSERT INTO maintenance (stock_num, reason) values ($stock, '$maint');";
	if(!mysqli_query($link,$q1)){
		echo("Error description: " . mysqli_error($link));
		exit;
	}
	
	//Redirect to checkin page
	header("location: ../checkin_form.php"); 
?>