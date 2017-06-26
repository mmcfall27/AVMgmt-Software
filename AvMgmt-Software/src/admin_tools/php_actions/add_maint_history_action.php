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
	
	//insert the historical maint information
	$q1 = "INSERT INTO maint_history (stock_num, maint_documentation) values ($stock, '$maint');";
	if(!mysqli_query($link,$q1)){
		echo("Error description: " . mysqli_error($link));
		exit;
	}
	
	//Redirect to dbadmin page
	$_SESSION["dbadmin_code"] = 1; //Success Code
	header("location: ../../database_admin.php"); 
?>