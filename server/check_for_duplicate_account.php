<?php
	$servername = "localhost";
	$username = "root";
	$password = "root";
	$dbname = "Zampler";

	//create connection
	$conn = new mysqli($servername, $username, $password, $dbname);
	
	//check connection
	if(mysqli_connect_errno()) {
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
	
	$username =  mysqli_real_escape_string($conn, $_POST['username']);
	$email = mysqli_real_escape_string($conn, $_POST['email']);

	$sql = "SELECT * FROM Users WHERE username='$username' OR email='$email'";
	$result = mysqli_query($conn, $sql);

	$i = 0;
	while($r = mysqli_fetch_assoc($result)) {
	    $rows[$i] = $r;
	    $i++;
	}
	
	if($i > 0) {
		echo 'duplicate';
	}
	else {
		echo 'ok';
	}

	$conn->close();
?>