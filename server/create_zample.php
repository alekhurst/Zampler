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


	// zample metadata creation
	$sql = "INSERT INTO Zamples (id, user_id, school_id, course_id, title, professor, date_completed, difficulty, curved, likes, date_submitted) 
	               VALUES (DEFAULT, '$user_id', '$school_id', '$course_id', '$zample_name', '$professor', '$date_completed', '$difficulty', '$curved', '0', CURRENT_TIMESTAMP);";
	mysqli_query($conn,$sql);

	// fetch zample that was just created
	$sql = "SELECT * FROM Zamples WHERE user_id=$user_id";
	$result = mysqli_query($conn, $sql);
	$i = 0;
	while($r = mysqli_fetch_assoc($result)) {
	    $rows[$i] = $r;
	    $i++;
	}
	$i = $i - 1;
	$zample_id = $rows[$i]['id'];

	// file metadata create
	$individual_files = explode(',', $files);
	for($i=0; $i<count($individual_files); $i++) {
		$file_to_insert = $individual_files[$i];
		$sql = "INSERT INTO Files (id, zample_id, name) VALUES (DEFAULT, '$zample_id', '$file_to_insert')";
		mysqli_query($conn,$sql);
	}


	echo $zample_id;

	$conn->close();
?>