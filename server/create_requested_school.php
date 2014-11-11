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

	$name =  mysqli_real_escape_string($conn, $_POST['name']);

	$sql = "INSERT INTO RequestedSchools (id, name) VALUES (DEFAULT, '$name');";

	mysqli_query($conn,$sql);

	echo $sql;

	$conn->close();
?>