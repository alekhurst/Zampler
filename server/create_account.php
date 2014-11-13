<?php
	session_start();

	require_once 'database_config.php';

	$email =  mysqli_real_escape_string($conn, $_POST['email']);
	$username =  mysqli_real_escape_string($conn, $_POST['username']);
	$password =  sha1(mysqli_real_escape_string($conn, $_POST['password']));

	$sql = "INSERT INTO Users (id, username, email, password, account_created, last_login) 
	               VALUES (DEFAULT, '$username', '$email', '$password', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)";

	mysqli_query($conn,$sql);

	
	$sql = "SELECT * FROM Users WHERE username='$username' AND email='$email'";
	$result = mysqli_query($conn, $sql);

	$i = 0;
	while($r = mysqli_fetch_assoc($result)) {
	    $rows[$i] = $r;
	    $i++;
	}
	
	$_SESSION['logged_in_with_id'] = $rows[0]['id'];

	$conn->close();
?>