<?php
	session_start();
	if($_SESSION['user_type'] == 0){
		header('location: ../../login.php');
	}
	
	//Local Wamp Server
	//$link = mysqli_connect("localhost", "root", "", "avdatabase");
	
	//CEM Server
	$link = mysqli_connect("localhost", "root", "Mtsu2017!", "avdatabase");

	if (!$link) {
		echo "Error: Unable to connect to MySQL." . PHP_EOL;
		echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
		echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
		exit;
	}
	
	//Variable Declarations
	$stock = $_POST["stock_num"];
	
	//Database Queries
	$q1 = "delete from equip_inv where stock_num = $stock";
	
	if(!mysqli_query($link, $q1)){
		echo("Error description: " . mysqli_error($link));
	}else{
		$_SESSION["dbadmin_code"] = 1; //Success Code
		header("location: ../../database_admin.php");
	}
?>
