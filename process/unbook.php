<?php 
	require ("../config.php");

			$id = $_POST['id'];

			$values = array('booked' => 0);
			$query = $fpdo->update('nextable_tables', $values, $id)->execute();

			header('location: ../index.php');

?>