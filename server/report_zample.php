<?php
	session_start();

	require_once 'database_config.php';

	$zample_id =  mysqli_real_escape_string($conn, $_POST['zample_id']);
	$user_id = $_SESSION['logged_in_with_id'];

	if(isset($user_id)) {
		$sql = "INSERT INTO ReportedZamples (id, zample_id, user_id) VALUES (DEFAULT, '$zample_id', '$user_id');";
		mysqli_query($conn,$sql);
		echo 'success';
	}

	$conn->close();
?>