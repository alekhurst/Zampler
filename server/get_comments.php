<?php
	require_once 'database_config.php';
	
	$zample_id =  mysqli_real_escape_string($conn, $_POST['zample_id']);

	$sql = "SELECT * FROM Comments WHERE zample_id=$zample_id";
	$result = mysqli_query($conn, $sql);

	$i = 0;
	while($r = mysqli_fetch_assoc($result)) {
	    $rows[$i] = $r;
	    $i++;
	}

	if(isset($rows))  {
		echo json_encode($rows);
	}
	else {
		echo 'null';
	}
	$conn->close();
?>