<?php
	//Start Session
	session_start();
	
	//reset dbadmin code
	$_SESSION["dbadmin_code"] = 0;
	
	//Variable Declarations
	$form = $_POST["report"];
	
	//build html anchor string for echo
	$temp = "location: ./reports/".$form.".php";
	header($temp);
?>