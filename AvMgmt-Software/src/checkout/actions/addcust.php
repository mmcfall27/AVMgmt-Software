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
	$first = $_POST["first_name"];
	$last = $_POST["last_name"];
	$name = $last.",".$first;
	$acc = $_POST["acc_num"];
	$phone = $_POST["phone_num"];
	$email = $_POST["cust_email"];
	
	//Database Queries
	$q2 = "select cust_id from customer where (customer = \"$name\")and(acc_no = \"$acc\")and(phone = \"$phone\")and(cust_email = \"$email\");";
	$q3 = "select dept_name from departments where acc_num = \"$acc\";";
	$result1 = mysqli_query($link, $q2);
	$result2 = mysqli_query($link, $q3);
	$row = mysqli_fetch_array($result2);
	$dept = $row["dept_name"]; 
	$q1 = "insert into customer(customer, department, acc_no, phone, cust_email) VALUES(\"$name\",\"$dept\",\"$acc\",\"$phone\",\"$email\");";
	
	//Checks if the customer they entered already exists
	if(mysqli_num_rows($result1) == 0){
		$_SESSION["addcust_code"] = 1;
		mysqli_query($link, $q1); //customer doesn't already exists so run query to insert them
		header("location: ../checkout.php");
	}
	else{
		$_SESSION["addcust_code"] = 2;
		header("location: ../add_customer.php"); //customer already exists so report failure
	}
?>
