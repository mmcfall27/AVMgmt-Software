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
	
	//Check to see if the stock number is already in the table
	$q0 = "select stock_num from maintenance where stock_num = $stock;";
	if(!mysqli_query($link,$q0)){
		echo("Error description: " . mysqli_error($link));
		exit;
	}
	$result = mysqli_query($link, $q0);
	
	//if it doesnt exist insert it / if it does exists update the reason
	if(mysqli_num_rows($result) == 0){
		//Insert maintenance Table Query
		$q1 = "INSERT INTO maintenance (stock_num, reason) values ($stock, '$maint');";
		if(!mysqli_query($link,$q1)){
			echo("Error description: " . mysqli_error($link));
			exit;
		}
	}else{
		$q1 = "UPDATE maintenance SET reason = '$maint' where stock_num = $stock;";
		if(!mysqli_query($link,$q1)){
			echo("Error description: " . mysqli_error($link));
			exit;
		}
	}
	
	//Redirect to dbadmin page
	$_SESSION["dbadmin_code"] = 1; //Success Code
	header("location: ../../database_admin.php"); 
?>