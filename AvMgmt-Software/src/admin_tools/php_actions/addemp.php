<?php
	session_start();
	if($_SESSION['user_type'] == 0){
		header('location: ../../login.php');
	}
	
	//Local Wamp Server
	//$link = mysqli_connect("localhost", "root", "", "avdatabase");
	
	//CEM Server
	$link = mysqli_connect("localhost", "root", "Mtsu2017!", "avdatabase");

	//If the database server connection fails show errors
	if (!$link) {
		echo "Error: Unable to connect to MySQL." . PHP_EOL;
		echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
		echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
		exit;
	}
	
	//Variable Declarations
	$first = $_POST["first_name"];
	$last = $_POST["last_name"];
	$type = (int)$_POST["user_type"];
	$id = $_POST["user_id"];
	$pword = $_POST["user_pword"];
	$bday = $_POST["bday"];
	
	//Database Queries
	$q2 = "insert into emp_info(first_name,last_name,user_type,user_id,user_pword,emp_bday) VALUES(\"$first\",\"$last\",$type,\"$id\",\"$pword\",\"$bday\")";
	
	//Run Insertion Query
	if(!mysqli_query($link, $q2)){
		echo("Error description: " . mysqli_error($link)); //show error if insertion query fails
	}else{
		$_SESSION["dbadmin_code"] = 1; //Success Code
		header("location: ../../database_admin.php"); //Redirect to database admin page
	}
?>
