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

	$user_id =  mysqli_real_escape_string($conn, $_POST['user_id']);
	$zample_id =  mysqli_real_escape_string($conn, $_POST['zample_id']);

	$sql = "SELECT * FROM Zamples WHERE id=$zample_id";

	$result = mysqli_query($conn,$sql);

	$i = 0;
	while($r = mysqli_fetch_assoc($result)) {
	    $rows[$i] = $r;
	    $i++;
	}

	if($rows[0]['user_id'] == $user_id)
		echo 'yes';
	else 
		echo 'no';
	
	$conn->close();
?>