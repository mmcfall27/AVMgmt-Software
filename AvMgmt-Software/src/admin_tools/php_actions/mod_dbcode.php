<?php
	//Start Session
	session_start();
	
	//Change Session Variable
	$_SESSION["dbadmin_code"] = 0;
	
	//Redirect to Database Admin Page
	header("location: ../../database_admin.php");
?>
