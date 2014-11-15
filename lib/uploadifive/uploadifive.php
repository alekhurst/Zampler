<?php
/*
UploadiFive
Copyright (c) 2012 Reactive Apps, Ronnie Garcia
*/

// Set the uplaod directory
$uploadDir = __DIR__.'/../../user_uploads/';

// Set the allowed file extensions
$fileTypes = array('jpg', 'jpeg', 'png', 'pdf', 'txt', 'text', 'c', 'cpp', 'html', 'js', 'php', 'jvm', 'rb', 'py'); // Allowed file extensions

$verifyToken = md5('unique_salt' . $_POST['timestamp']);

if (!empty($_FILES) && $_POST['token'] == $verifyToken) {
	$tempFile = $_FILES['Filedata']['tmp_name'];
	$pray_for_unique = rand(0,10000);
	$targetFile = $uploadDir . time() . $pray_for_unique . $_FILES['Filedata']['name'];
	$upload_name = time() . $pray_for_unique . $_FILES['Filedata']['name'];

	// Validate the filetype
	$fileParts = pathinfo($_FILES['Filedata']['name']);
	if (in_array(strtolower($fileParts['extension']), $fileTypes)) {

		// Save the file
		move_uploaded_file($tempFile, $targetFile);

		// echo the new file name
		echo $upload_name;

	} else {

		// The file type wasn't allowed
		echo 'Invalid file type.';

	}
}
?>