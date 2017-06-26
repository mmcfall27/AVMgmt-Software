<?php
	session_start();
	if($_SESSION['user_type'] == 0){
		header('location: ../../login.php');
	}
	//Campus Hosted Virtual Server
	//$link = mysqli_connect("localhost", "root", "Mtsu2017!", "avdatabase");
	
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
	
	//Database Queries
	$q1 = "delete from customers where id = $id";
	
	//Run Deletion Query
	if(!mysqli_query($link, $q1)){
		echo("Error description: " . mysqli_error($link)); //show error if delete query fails
	}else{
		$_SESSION["dbadmin_code"] = 1; //Success Code
		header("location: ../../database_admin.php"); //redirects back to the database_admin page
	}
?>
