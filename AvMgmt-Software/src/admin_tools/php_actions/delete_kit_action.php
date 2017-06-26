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
	$kit_stock = $_POST["kit"];

	//Update equip_inv to reflect the stock number as being part of a kit
	//$q2 = "update equip_inv set kit_part = 'no' where stock_num = $equip_stock;";
	
	//Loop to set all parts in the kit as not being in a kit
	$query = "select part_stock_num from equip_kits where kit_stock_num = $kit_stock;";
	$result = mysqli_query($link, $query);
	while($row = mysqli_fetch_assoc($result)){
		$equip_stock = $row["part_stock_num"];
		$q2 = "update equip_inv set kit_part = 'no' where stock_num = $equip_stock;";
		if(!mysqli_query($link,$q2)){
			echo("Error description: " . mysqli_error($link));
			exit;
		}
	};
	
	//delete kit from equip_kits Table Query
	$q1 = "DELETE FROM equip_kits where kit_stock_num = $kit_stock;";
	if(!mysqli_query($link,$q1)){
		echo("Error description: " . mysqli_error($link));
		exit;
	}
	
	//Redirect to checkin page
	$_SESSION["dbadmin_code"] = 1; //Success Code
	header("location: ../../database_admin.php"); 
?>