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
	$school_id =  mysqli_real_escape_string($conn, $_POST['school_id']);
	$course_id =  mysqli_real_escape_string($conn, $_POST['course_id']);
	$zample_name =  mysqli_real_escape_string($conn, $_POST['zample_name']);
	$professor =  mysqli_real_escape_string($conn, $_POST['professor']);
	$date_completed =  mysqli_real_escape_string($conn, $_POST['date_completed']);
	$difficulty =  mysqli_real_escape_string($conn, $_POST['difficulty']);
	$curved =  mysqli_real_escape_string($conn, $_POST['curved']);
	$images =  mysqli_real_escape_string($conn, $_POST['user_id']);


	$sql = "INSERT INTO Zamples (id, user_id, school_id, course_id, title, professor, date_completed, difficulty, curved, likes, images, date_submitted) 
	               VALUES (DEFAULT, '$user_id', '$school_id', '$course_id', '$zample_name', '$professor', '$date_completed', '$difficulty', '$curved', '0', '$images', CURRENT_TIMESTAMP);";

	mysqli_query($conn,$sql);

	echo $sql;

	$conn->close();
?>