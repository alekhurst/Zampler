<?php
	session_start();

	require_once 'database_config.php';

	$email =  mysqli_real_escape_string($conn, $_POST['email']);
	$password =  sha1(mysqli_real_escape_string($conn, $_POST['password']));

	$sql = "SELECT * FROM Users WHERE email='$email' AND password='$password'";
	$result = mysqli_query($conn, $sql);

	$i = 0;
	while($r = mysqli_fetch_assoc($result)) {
	    $rows[$i] = $r;
	    $i++;
	}
	
	if( $i > 0) {
		$_SESSION['logged_in_with_id'] = $rows[0]['id'];
		$json[0] = $rows[0]['id'];
		$json[1] = $rows[0]['username'];
		$json[2] = $rows[0]['email'];
		echo json_encode($json);
	}
	else {
		echo 'invalid';
	}

	
?>