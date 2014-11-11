<?php
	$servername = "localhost";
	$username = "root";
	$password = "root";
	$dbname = "Zampler";

	//create connection
	$conn = new mysqli($servername, $username, $password, $dbname);
	
	//check connection
	if(mysqli_connect_errno()) {
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}

	$name =  mysqli_real_escape_string($conn, $_POST['name']);
	$school_id = mysqli_real_escape_string($conn, $_POST['school_id']);
	$curve = mysqli_real_escape_string($conn, $_POST['curve']);
	$difficulty = mysqli_real_escape_string($conn, $_POST['difficulty']);

	if($curve == 'na')
		$curve = -1;

	// check if course exists
	$sql = "SELECT * FROM Courses WHERE name='$name' AND school_id=$school_id";
	$result = mysqli_query($conn, $sql);

	$i = 0;
	while($r = mysqli_fetch_assoc($result)) {
	    $rows[$i] = $r;
	    $i++;
	}

	if ($i > 0) {// course did exist, exit with warning
		echo 'duplicate';
	}
	else {
		$rows;

		$sql = "INSERT INTO Courses (id, name, school_id, zample_count, difficulty, curve_frequency) VALUES (DEFAULT, '$name', $school_id, '1', '$difficulty', '$curve');";

		mysqli_query($conn,$sql);

		$sql = "SELECT * FROM Courses WHERE name='$name' AND school_id=$school_id";
		$result = mysqli_query($conn, $sql);

		$i = 0;
		while($r = mysqli_fetch_assoc($result)) {
		    $rows[$i] = $r;
		    $i++;
		}

		echo json_encode($rows);
	}

	$conn->close();
?>