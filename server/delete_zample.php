<?php
	require_once 'database_config.php';

	$id =  mysqli_real_escape_string($conn, $_POST['zample_id']);
	$user_id =  mysqli_real_escape_string($conn, $_POST['user_id']);

	$sql = "SELECT * FROM Zamples WHERE id=$id";
	$result = mysqli_query($conn,$sql);
	$i = 0;
	while($r = mysqli_fetch_assoc($result)) {
	    $rows[$i] = $r;
	    $i++;
	}
	$course_id = $rows[0]['course_id'];

	if($rows[0]['user_id'] != $user_id)
		echo '';
	else {
		$sql = "DELETE FROM Zamples WHERE id=$id";
		mysqli_query($conn,$sql);

		echo $course_id;
	}
	$conn->close();
?>