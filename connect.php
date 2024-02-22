<?php
	// Database configuration 
	$host     = "localhost"; 
	$db_user = "root"; 
	$db_password = "root"; 
	$db_name     = "taskmanager"; 
	 
	// Create database connection 
	$con =  new mysqli($host, $db_user, $db_password, $db_name); 
	 
	// Check connection 
	if ($con->connect_error) { 
	    die("Connection failed: " . $con->connect_error); 
	} 
?>