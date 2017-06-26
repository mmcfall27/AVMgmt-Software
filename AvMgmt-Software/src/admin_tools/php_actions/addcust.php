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
	$first = $_POST["first_name"];
	$last = $_POST["last_name"];
	$name = $last.",".$first;
	$acc = $_POST["acc_num"];
	$phone = $_POST["phone_num"];
	$email = $_POST["email"];
	
	//Database Queries
	$q2 = "select id from customers where (name = \"$name\")and(acc_num = \"$acc\")and(email = \"$email\")and(phone = \"$phone\");";
	$q3 = "select dept_name from departments where acc_num = \"$acc\";";
	$result1 = mysqli_query($link, $q2); //finds out if the customer already exists
	$result2 = mysqli_query($link, $q3); //grabs the dept name from the departments table
	$row = mysqli_fetch_array($result2);
	$dept = $row["dept_name"];  //stores the dept name
	$q1 = "insert into customers(name, department, acc_num, phone, email) VALUES(\"$name\",\"$dept\",\"$acc\",\"$phone\",\"$email\");";
	
	//Checks if the customer they entered already exists
	if(mysqli_num_rows($result1) == 0){ //if they dont exist
		if(!mysqli_query($link, $q1)){ //run the insertion query
			echo("Error description: " . mysqli_error($link)); //show error if insertion query fails
		}else{
			$_SESSION["dbadmin_code"] = 1; //Success Code
			header("location: ../../database_admin.php");			
		}
	}
	else{
		echo("Error description: Customer already exists in the database.");
	}
?>
