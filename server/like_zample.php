<?php
	session_start();

	require_once 'database_config.php';

	$zample_id =  mysqli_real_escape_string($conn, $_POST['zample_id']);
	$user_id = $_SESSION['logged_in_with_id'];

	if(isset($user_id)) {
		$sql = "INSERT INTO Likes (id, zample_id, user_id) VALUES (DEFAULT, '$zample_id', '$user_id');";
		mysqli_query($conn, $sql);

		$sql = "SELECT * FROM Zamples WHERE id=$zample_id";
		$result = mysqli_query($conn, $sql);

		$i = 0;
		while($r = mysqli_fetch_assoc($result)) {
		    $rows[$i] = $r;
		    $i++;
		}

		$current_likes = $rows[0]['likes'];
		$new_likes = $current_likes + 1;

		$sql = "UPDATE Zamples SET likes=$new_likes WHERE id=$zample_id";
		mysqli_query($conn, $sql);

		mysqli_query($conn,$sql);
		echo 'success';
	} else {
		echo 'error';
	}

	$conn->close();
?>