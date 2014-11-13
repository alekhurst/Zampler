<?php
	require_once 'database_config.php';
	
	$id =  mysqli_real_escape_string($conn, $_POST['id']);

	$sql = "SELECT * FROM Courses WHERE id=$id";
	$result = mysqli_query($conn, $sql);

	$i = 0;
	while($r = mysqli_fetch_assoc($result)) {
	    $rows[$i] = $r;
	    $i++;
	}
	
	echo json_encode($rows);
	$conn->close();
?>