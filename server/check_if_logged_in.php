<?php
	session_start();

	if(isset($_SESSION['logged_in_with_id'])) {
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

		$id = $_SESSION['logged_in_with_id'];
		$sql = "SELECT * FROM Users WHERE id=$id";
		$result = mysqli_query($conn, $sql);

		$i = 0;
		while($r = mysqli_fetch_assoc($result)) {
		    $rows[$i] = $r;
		    $i++;
		}
		
		$json[0] = $rows[0]['id'];
		$json[1] = $rows[0]['username'];
		$json[2] = $rows[0]['email'];

		echo json_encode($json);
	} 
	else {
		echo 'not_logged_in';
	}
?>