<?php 

	require ("../config.php");

	$name = $_POST['tableName'];

	if(empty($name)){
		$errors['name'] = 'Name time must be filled';
	}

	if(empty($errors))
	{
		$values = array('table_name' => $name, 'booked' => 0);
		$query = $fpdo->insertInto('nextable_tables', $values)->execute();

		header('location: ../index.php');
	} else {
		header('location: ../index.php');
	}

?>