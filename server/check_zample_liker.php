<?php
	session_start();

	require_once 'database_config.php';

	$zample_id =  mysqli_real_escape_string($conn, $_POST['zample_id']);
	$user_id = $_SESSION['logged_in_with_id'];

	if(isset($user_id)) {
		$user_already_liked_this_zample = false;

		$sql = "SELECT * FROM Likes WHERE zample_id=$zample_id";
		$result = mysqli_query($conn,$sql);

		$i = 0;
		while($r = mysqli_fetch_assoc($result)) {
		    $rows[$i] = $r;
		    if($rows[$i]['user_id'] == $user_id) {
		    	$user_already_liked_this_zample = true;
		    	break;
		    }
		    $i++;
		}

		if($user_already_liked_this_zample == true)
			echo 'yes';
		else 
			echo 'no';
	} else {
		echo 'error';
	}

	
	
	$conn->close();
?>