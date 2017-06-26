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
	$maint = $_POST["maint"];
	$_SESSION["stock_number"] = $stock;
	
	//Database Queries
	$q1 = "update equip_inv set in_maintenance = $maint where stock_num = $stock";
	$q2 = "delete from maintenance where stock_num = $stock;";
	
	//Run Update Query
	if(!mysqli_query($link, $q1)){ //run update query to change equip_in in_maintenance column 
		echo("Error description: " . mysqli_error($link)); //show error if update query fails
		exit;
	}
	
	if($maint == 0){ //if changing maintenance column from yes to no
		if(!mysqli_query($link, $q2)){ //delete record from maintenance table
			echo("Error description: " . mysqli_error($link)); //show error if delete query fails
			exit;
		}
		$_SESSION["dbadmin_code"] = 1; //Success Code
		header("location: ../add_maint_history.php");	//redirect to database admin page
	}else{
		header("location: ../add_maint_req.php");	//redirect to add_maint_req admin tool
	}
?>
