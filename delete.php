<?php 
	require ("config.php");
	$id = $_GET['id'];

	$fpdo->deleteFrom('nextable_bookings', $id)->execute();
	header('location: index.php');
?>