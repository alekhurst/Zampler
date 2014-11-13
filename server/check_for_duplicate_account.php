<?php
	require_once 'database_config.php';
	
	$username =  mysqli_real_escape_string($conn, $_POST['username']);
	$email = mysqli_real_escape_string($conn, $_POST['email']);

	$sql = "SELECT * FROM Users WHERE username='$username' OR email='$email'";
	$result = mysqli_query($conn, $sql);

	$i = 0;
	while($r = mysqli_fetch_assoc($result)) {
	    $rows[$i] = $r;
	    $i++;
	}
	
	if($i > 0) {
		echo 'duplicate';
	}
	else {
		echo 'ok';
	}

	$conn->close();
?>