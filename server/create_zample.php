<?php
	require_once 'database_config.php';

	$user_id =  mysqli_real_escape_string($conn, $_POST['user_id']);
	$school_id =  mysqli_real_escape_string($conn, $_POST['school_id']);
	$course_id =  mysqli_real_escape_string($conn, $_POST['course_id']);
	$zample_name =  mysqli_real_escape_string($conn, $_POST['zample_name']);
	$professor =  mysqli_real_escape_string($conn, $_POST['professor']);
	$date_completed =  mysqli_real_escape_string($conn, $_POST['date_completed']);
	$difficulty =  mysqli_real_escape_string($conn, $_POST['difficulty']);
	$curved =  mysqli_real_escape_string($conn, $_POST['curved']);
	$files =  mysqli_real_escape_string($conn, $_POST['files']);


	$sql = "INSERT INTO Zamples (id, user_id, school_id, course_id, title, professor, date_completed, difficulty, curved, likes, files, date_submitted) 
	               VALUES (DEFAULT, '$user_id', '$school_id', '$course_id', '$zample_name', '$professor', '$date_completed', '$difficulty', '$curved', '0', '$files', CURRENT_TIMESTAMP);";
	mysqli_query($conn,$sql);

	$sql = "SELECT * FROM Zamples WHERE user_id=$user_id";
	$result = mysqli_query($conn, $sql);
	$i = 0;
	while($r = mysqli_fetch_assoc($result)) {
	    $rows[$i] = $r;
	    $i++;
	}
	$i = $i - 1;
	echo $rows[$i]['id'];

	$conn->close();
?>