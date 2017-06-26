<?php
	//Variable Declarations
	$form = $_POST["admin_tools"];
	
	//build html anchor string for echo
	$temp = "location: ".$form.".php";
	header($temp);
?>