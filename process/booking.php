<?php 
	require ("../config.php");

		echo $start = date("Y-m-d H:i:s", strtotime($_POST['start']));
		echo $end = date("Y-m-d H:i:s", strtotime($_POST['end']));
		$client_name = $_POST['client_name'];
		$table_id = $_POST['table_id'];
		$oldvals = array('start' => $start, 'end' => $end, 'client_name' => $client_name);
		$errors = array();


		if(empty($start)){
			$errors['start'] = 'Date time must be filled';
		}
		if(empty($end)){
			$errors['end'] = 'Date time must be filled';
		}
		if(empty($client_name)){
			$errors['client_name'] = 'Client name must be filled';
		}

		if(empty($errors))
		{
			$values = array('booking_start' => $start, 'booking_end' => $end, 'client_name' => $client_name, 'table_id' => $table_id);
			$query = $fpdo->insertInto('nextable_bookings', $values)->execute();

			header('location: ../index.php');
			var_dump($query);
		} else {
			foreach ($errors as $key => $value) {
				$_SESSION['errors'][$key] = $value;
			}
			foreach ($oldvals as $key => $value) {
				$_SESSION['oldvals'][$key] = $value;
			}
			header('location: ../index.php');
		}
?>