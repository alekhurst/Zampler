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

	$id =  mysqli_real_escape_string($conn, $_POST['id']);
	$sql = "SELECT * FROM Zamples WHERE id=$id";
	$result = mysqli_query($conn,$sql);
	$i = 0;
	while($r = mysqli_fetch_assoc($result)) {
	    $rows[$i] = $r;
	    $i++;
	}
	$course_id = $rows[0]['course_id'];

	$sql = "DELETE FROM Zamples WHERE id=$id";
	mysqli_query($conn,$sql);

	echo $course_id;

	$conn->close();
?>