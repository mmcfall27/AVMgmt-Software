<?php
	//Start Session
	session_start();
	
	//$link = mysqli_connect("localhost", "root", "Mtsu2017!", "avdatabase"); //Local Wamp Host
	$link = mysqli_connect("localhost", "root", "Mtsu2017!", "avdatabase"); //MTSU Hosted Virtual Server

	if (!$link) {
		echo "Error: Unable to connect to MySQL." . PHP_EOL;
		echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
		echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
		exit;
	}
	
	//Variable Declarations
	$userid = $_POST["user_id"];
	$password = $_POST["pword"];
	
	//Database Queries
	$q1 = "select user_type, user_id, user_pword from emp_info where BINARY user_id = \"$userid\" and BINARY user_pword = \"$password\";";
	$result = mysqli_query($link, $q1);
	$row = mysqli_fetch_assoc($result);
	if(mysqli_num_rows($result) == 0){
		$_SESSION['user_type'] = 9;
		header('location: ./login.php');
	}else{
		$_SESSION['user_type'] = $row['user_type'];
		$_SESSION['user_id'] = $row['user_id'];
		header('location: ./homepage.php');
	}
?>
