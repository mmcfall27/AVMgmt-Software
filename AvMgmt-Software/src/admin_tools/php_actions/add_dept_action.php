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
	$dept = $_POST["dept_name"];
	$acc_num = $_POST["acc_num"];
	
	//Database Queries
	$q1 = "select id from departments where (dept_name = \"$dept\")and(acc_num = \"$acc\");";
	if(!mysqli_query($link, $q1)){ //run the insertion query
		echo("Error description: " . mysqli_error($link)); //show error if select query fails
		echo "<form action = '../../database_admin.php'><input type = 'submit' value = Return Database Admin Page'></form>";
	}
	$result1 = mysqli_query($link, $q1); //finds out if the department already exists
	
	//Department Insertion Query
	$q2 = "insert into departments(acc_num, dept_name) VALUES('$acc_num','$dept');";
	
	//Checks if the department they entered already exists
	if(mysqli_num_rows($result1) == 0){ //if it doesn't exist
		if(!mysqli_query($link, $q2)){ //run the insertion query
			echo("Error description: " . mysqli_error($link)); //show error if insertion query fails
			echo "<form action = '../../database_admin.php'><input type = 'submit' value = Return Database Admin Page'></form>";
		}else{
			$_SESSION["dbadmin_code"] = 1; //Success Code
			header("location: ../../database_admin.php");			
		}
	}
	else{
		echo("Error description: Department already exists in the database.");
		echo "<form action = '../../database_admin.php'><input type = 'submit' value = Return Database Admin Page'></form>";
	}
?>
