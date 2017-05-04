<?php 
	require ("config.php");

	$tables = $fpdo->from('nextable_tables')->fetchAll();

?>

<!DOCTYPE html>
<html>
<head>
	<title>NexTable - Keep order of your tables</title>

	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/styles.css">

</head>
<body>
 <nav id="mainNav" class="navbar navbar-default navbar-fixed-top navbar-custom">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header page-scroll">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span> Menu <i class="fa fa-bars"></i>
                </button>
                <a class="navbar-brand" href="#page-top">NexTable</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                <li><a href="#">Support</a></li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->
    </nav>

<main class="tables">
	<?php 
	foreach ($tables as $table) {	?>
		<article class="tables__table <?php if($table['booked'] == 1){ echo 'tables__table--booked'; } ?>"  data-toggle="modal" data-target="#<?php echo $table['table_name'] ?>">
			<h3 class="tables__id"><?php echo $table['table_name']; ?></h3>

		</article>
	<?php 
		}
	?>
</main>

<?php foreach($tables as $table) { 

	$results = $fpdo->from("nextable_bookings")->leftJoin('nextable_tables ON nextable_tables.id = nextable_bookings.table_id')->select('table_name')->where('table_id', $table['id'])->where('DATE(`booking_start`) = CURDATE()')->fetchAll();

	?>

<!-- Modal <?php echo $table['table_name']; ?>-->
<div class="modal fade" id="<?php echo $table['table_name']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Table: <?php echo $table['table_name']; ?></h4>
      </div>
      <div class="modal-body">
      	<section class="panel clearfix">
	      	<ul>
	      		<?php 
	      			foreach ($results as $result)
	      			{
	      		?>
	      				<li><form action="delete.php?id=<?php echo $result['id']; ?>" method="POST"><button class="btn btn-danger btn-xs pull-right" type="submit">X</button></form><?php echo $result['client_name'] ?> <span class="pull-right"><?php 
	      					$start = date("D d H:i", strtotime($result['booking_start'])); 
	      					$end =  date("H:i", strtotime($result['booking_end'])); 
	      				echo $start?> - <?php echo $end; 
	      				?> </span></li>
	      		<?php
	      			}
	      		?>
	      	</ul>
      	</section>
      	<form action="booking.php" method="POST">
      	<input type="hidden" name="table_id" value="<?php echo $result['table_id']; ?>">
      	<h3>Add new booking</h3>
      		<section class="form-group <?php if(!empty($_SESSION['errors']['start']))
		      {
		        echo 'has-error';
		      }
		      ?>"">
      			<div class="col-md-6">
      			<label>Booking start</label>
      				<input type="datetime-local" name="start" class="form-control">
      			</div>
      			<div class=" col-md-6">
      			<label>Booking end</label>
      				<input type="datetime-local" name="end" class="form-control">
      			</div>
      		</section>
	      	<section class="form-group <?php if(!empty($_SESSION['errors']['client_name']))
		      {
		        echo 'has-error';
		      }
		      ?>""">
	      		<label>Client name</label>
	      		<input type="text" name="client_name" class="modal__client form-control" placeholder="client name" >
	      	</section>
	      	<button type="submit" class="btn btn-success">Add booking</button>
      	</form>
      	
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <form class="pull-left" method="POST" action="booknow.php">
        <input type="hidden" name="id" value="<?php echo $table['id']; ?>">
      		<button type="submit" class="btn btn-primary">Book now</button>
      	</form>
      </div>
    </div>
  </div>
</div>
<?php }?>



<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/main.js"></script>

<?php 

unset($_SESSION['errors']);
unset($_SESSION['oldvals']);
?>
</body>
</html>

