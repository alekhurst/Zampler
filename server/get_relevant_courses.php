<?php
	require_once 'database_config.php';
	
	$school_id =  mysqli_real_escape_string($conn, $_POST['school']);

	$sql = "SELECT * FROM Courses WHERE school_id=$school_id";
	$result = mysqli_query($conn, $sql);

	$i = 0;
	while($r = mysqli_fetch_assoc($result)) {
	    $rows[$i] = $r;
	    $i++;
	}
	
	if(isset($rows))
		echo json_encode($rows);
	else
		echo 'null';
	$conn->close();
?>