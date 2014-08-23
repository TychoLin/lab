<?php
if (isset($_FILES["test"])) {
	header("Content-Type: application/json");
	echo json_encode($_FILES["test"]);
}

if ($_SERVER["REQUEST_METHOD"] == "PUT") {
	$file = file_get_contents("php://input");
	$data = explode(",", $file);
	file_put_contents("test.jpg", base64_decode($data[1]));
	echo $file;
}
?>