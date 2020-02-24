<?php
$server = "localhost";
$user 	= "root";
$pwd 	= "";
$db 	= "db_bps";
$conn 	= new mysqli($server,$user,$pwd,$db);

if ($conn->connect_errno) {
	echo "Failed to connect to MySQL: (" . $conn->connect_errno . ") " . $conn->connect_error;
}

function getFileSize($file, $digits = 2){
	if (is_file($file)) {
		$filePath = $file;
		if (!realpath($filePath)) {
			$filePath = $_SERVER["DOCUMENT_ROOT"] . $filePath;
		}
		$fileSize = filesize($filePath);
		return $fileSize;
	}
	return false;
}

function cekDt($data){
  global $conn;
  $filter = mysqli_real_escape_string($conn, $data);
  return $filter;
}
?>