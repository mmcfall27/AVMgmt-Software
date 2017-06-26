<?php
	//Start Session
	session_start();
	
	//Change Session Variable
	$_SESSION["addcust_code"] = 0;
	
	//Redirect to Add Customer Form
	header("location: ../add_customer.php");
?>
