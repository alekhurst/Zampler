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
	
	$id =  mysqli_real_escape_string($conn, $_POST['course']);

	$sql = "SELECT * FROM Zamples WHERE course_id=$id";
	$result = mysqli_query($conn, $sql);

	$i = 0;
	$total_curve = 0;
	$total_curved_zamples = 0;
	$total_difficulty = 0;
	
	while($r = mysqli_fetch_assoc($result)) {
	    $rows[$i] = $r;
	    $total_difficulty += $rows[$i]['difficulty'];
	    if($rows[$i]['curved'] >= 1) {
	    	$total_curve += $rows[$i]['curved'];
	    	$total_curved_zamples += 1;
	    }
	    $i++;
	}
	
	if($total_curve != 0)
		$total_curve = $total_curve / $total_curved_zamples;
	else 
		$total_curve = -1;
	$total_difficulty = $total_difficulty / $i;
	$total_zamples = $i;

	$sql = "UPDATE Courses SET zample_count=$total_zamples,  difficulty=$total_difficulty, curve_frequency=$total_curve WHERE id=$id";
	$result = mysqli_query($conn, $sql);

	echo json_encode($rows);

	$conn->close();
?>