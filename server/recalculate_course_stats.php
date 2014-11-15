<?php
	require_once 'database_config.php';

	$id =  mysqli_real_escape_string($conn, $_POST['course']);

	$sql = "SELECT * FROM Zamples WHERE course_id=$id";
	$result = mysqli_query($conn, $sql);

	$i = 0;
	$total_curve = 0;
	$no_curve_yet = 1;
	$total_curved_zamples = 0;
	$total_difficulty = 0;
	
	while($r = mysqli_fetch_assoc($result)) {
	    $rows[$i] = $r;
	    $total_difficulty += $rows[$i]['difficulty'];
	    if($rows[$i]['curved'] >= 0) {
	    	if($no_curve_yet == 1)
	    		$no_curve_yet = 0;
	    	$total_curve += $rows[$i]['curved'];
	    	$total_curved_zamples += 1;
	    }
	    $i++;
	}
	
	if($i == 0) { // delete course if no zamples in it
		$sql = "DELETE FROM Courses WHERE id=$id";
		mysqli_query($conn, $sql);
	}
	else {
		if($no_curve_yet)
			$total_curve = -1;
		else 
			$total_curve = $total_curve / $total_curved_zamples;
		
		$total_difficulty = $total_difficulty / $i;
		$total_zamples = $i;

		$sql = "UPDATE Courses SET zample_count=$total_zamples,  difficulty=$total_difficulty, curve_frequency=$total_curve WHERE id=$id";
		$result = mysqli_query($conn, $sql);

		echo json_encode($rows);
	}

	$conn->close();
?>