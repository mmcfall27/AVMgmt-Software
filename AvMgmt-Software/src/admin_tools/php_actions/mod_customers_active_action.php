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
	$id = $_POST["cust_id"];
	$active = $_POST["active"];
	
	//Database Queries
	$q1 = "update customers set active = '$active' where id = $id";
	
	//Run Update Query
	if(!mysqli_query($link, $q1)){ //run update query to change customers active column 
		echo("Error description: " . mysqli_error($link)); //show error if update query fails
		exit;
	}
	$_SESSION["dbadmin_code"] = 1; //Success Code
	header("location: ../../database_admin.php");	//redirect to database admin page
?>
