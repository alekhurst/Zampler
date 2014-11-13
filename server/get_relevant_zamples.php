<?php
	require_once 'database_config.php';
	
	$course_id =  mysqli_real_escape_string($conn, $_POST['course_id']);

	$sql = "SELECT * FROM Zamples WHERE course_id=$course_id";
	$result = mysqli_query($conn, $sql);

	$i = 0;
	while($r = mysqli_fetch_assoc($result)) {
	    $rows[$i] = $r;
	    $i++;
	}
	if(isset($rows)) 
		echo json_encode($rows);
	$conn->close();
?>