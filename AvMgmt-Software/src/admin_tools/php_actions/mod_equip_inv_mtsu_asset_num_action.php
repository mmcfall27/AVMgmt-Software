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
	$mtsu = $_POST["mtsu_num"];
	
	//Database Queries
	$q1 = "update equip_inv set mtsu_asset_num = '$mtsu' where stock_num = $stock";
	
	//Run Update Query
	if(!mysqli_query($link, $q1)){
		echo("Error description: " . mysqli_error($link)); //show error if update query fails
		echo "<form action = '../../database_admin.php'><input type = 'submit' value = 'Return to database admin page'></form>";
	}else{
		$_SESSION["dbadmin_code"] = 1; //Success Code
		header("location: ../../database_admin.php");	//redirect to database admin page
	}
?>
