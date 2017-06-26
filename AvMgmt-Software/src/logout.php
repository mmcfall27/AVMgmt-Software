<?php
	//Start Session
	session_start();
	
	//Change Session Variable
	$_SESSION["user_id"] = 0;
	$_SESSION["user_type"] = 0;
	$_SESSION["addcust_code"] = 0;
	$_SESSION["dbadmin_code"] = 0;
	$_SESSION["work_number"] = 0;
	$_SESSION["stock_number"] = 0;
	$_SESSION["customer_id"] = 0;
	
	//Redirect to Add Customer Form
	header("location: ./login.php");
?>