<?php

$conn = mysqli_connect("localhost","root","libraryIT---2024","cart_system");
	if (mysqli_connect_errno()){
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
		die();
		}
?>