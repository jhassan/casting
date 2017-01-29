<?php
$DB_Server = "localhost";
	$DB_Username ="root";
	$DB_Password = "";
	$DB_DBName = "casting";

	// Create connection
	$conn = mysqli_connect($DB_Server, $DB_Username, $DB_Password,$DB_DBName);
	if (!$conn) {

	    die("Connection failed: " . mysqli_connect_error());

	}

	// Define COA
	$InventoryCOA = "100001";
	$WorkingProcessCOA = "100001";
	$WorkingProcessCOA = "100001";
	$FinishGoodsCOA = "100001";
	$OwnerGoldCOA = "100001";
?>