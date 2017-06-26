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
	$name = $_POST["equip_name"];
	$loc = $_POST["storage_loc"];
	$date = $_POST["date_received"];
	$manufacturer = $_POST["manufacturer"];
	$cost = $_POST["equip_cost"];
	$model_num = $_POST["model_num"];
	$serial_num = $_POST["serial_num"];
	
	//Database Queries
	$q1 = "insert into equip_inv(stock_num, mtsu_asset_num, equip_name, equip_location, date_received, manufacturer, equip_cost, model_num, serial_num) VALUES($stock,$mtsu,\"$name\",\"$loc\",\"$date\",\"$manufacturer\",$cost,'$model_num','$serial_num')";
	
	//Run Insertion Query
	if(!mysqli_query($link, $q1)){
		echo("Error description: " . mysqli_error($link)); //show error if insertion query fails
	}else{
		$_SESSION["dbadmin_code"] = 1; //Success Code
		header("location: ../../database_admin.php");	//redirect to database admin page
	}
?>
