<?php
	//$link = mysqli_connect("localhost", "root", "Mtsu2017!", "avdatabase"); //Local Wamp Host
	$link = mysqli_connect("localhost", "root", "Mtsu2017!", "avdatabase"); //MTSU Hosted Virtual Server

	if (!$link) {
		echo "Error: Unable to connect to MySQL." . PHP_EOL;
		echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
		echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
		exit;
	}
	
	//Variables
	$subject = "Audio Visual Equipment Due Soon";
	$header = "From: mmcfall2@gmail.com";
	
	//Selection query to get data
	$q0 = "select equip_inv.equip_name, customers.name, customers.email, loans.checkout_date, loans.due_date
			from loans
			inner join equip_inv on equip_inv.stock_num = loans.stock_num
			inner join customers on customers.id = loans.cust_id
			where loans.returned = 'no'
			and due_date = curdate() + 1;";
			
	//Run query
	$result = mysqli_query($link, $q0);
	
	//for each row in our results do this
	while($row = mysqli_fetch_assoc($result)){
		//Assign Email Variable
		$email = $row["email"];
		
		//Construct Message with data from query
		$message = "Hello " . $row["customers.name"] . ",\n\n" . "The " . $row["equip_name"] . " that you checked out on "
						. $row["checkout_date"] . " is due back on " . $row["due_date"] . ".\n\n"
						. "If you believe this email was sent in error please contact us at (615)898-2711.\n\n"
						. "Regards, \nMTSU Audio Visual Department";
		
		//Send Email
		if(mail($email, $subject, $message, $header)){
			echo "The message was sent.";
		}else{
			echo "The message wasn't sent.";
		}
	}
?>
