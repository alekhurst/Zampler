<?php
	session_start();

	require_once 'database_config.php';

	$zample_id =  mysqli_real_escape_string($conn, $_POST['zample_id']);
	$body = mysqli_real_escape_string($conn, $_POST['body']);
	$user_id = $_SESSION['logged_in_with_id'];
	$user_name = mysqli_real_escape_string($conn, $_POST['user_name']);

	if(isset($user_id)) {
		$sql = "INSERT INTO Comments (id, user_id, user_name, zample_id, body) VALUES (DEFAULT, '$user_id', '$user_name', '$zample_id', '$body');";

		mysqli_query($conn,$sql);

		echo 'success';
	} 
	else {
		echo 'null';
	}
	$conn->close();
?>