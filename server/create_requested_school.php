<?php
	require_once 'database_config.php';

	$name =  mysqli_real_escape_string($conn, $_POST['name']);

	$sql = "INSERT INTO RequestedSchools (id, name) VALUES (DEFAULT, '$name');";

	mysqli_query($conn,$sql);

	echo $sql;

	$conn->close();
?>