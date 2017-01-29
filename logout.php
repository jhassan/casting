<?php
	include_once('conn.php');
	$data = json_decode(file_get_contents("php://input"));
	$token = $data->token;
	$sql = " UPDATE users SET remember_token = '' WHERE remember_token = ".$token." ";
    $query = mysqli_query($conn,$sql);
?>