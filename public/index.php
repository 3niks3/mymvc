
<html lang="en">
	<head>
    	<meta charset="utf-8">
    	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    	<meta name="viewport" content="width=device-width, initial-scale=1">

    	<title>MyBank</title>

    	<link href="css/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  </head>
	<body>
		<div class="container">
		<div class="row" style="margin-top:30px;">
			<div class="panel panel-default">
				<div class="panel-body text-center">
    				<h3>My MVC</h3>
  				</div>
			</div>
		</div>

<?php

require_once '../app/init.php';



if(Session::exists('success')){
	echo '<ul class="list-group">';
		foreach (Session::flash('success') as  $suces) {
			echo '<li class="list-group-item list-group-item-success">'.escape($suces).'</li>';
		}
	echo'</ul>';
	//echo ''.escape(Session::flash('success')).'';
}

if(Session::exists('errors')){
	echo '<ul class="list-group">';
		foreach (Session::flash('errors') as  $error) {
			echo '<li class="list-group-item list-group-item-danger">'.escape($error).'</li>';
		}
	echo'</ul>';
	//echo escape(Session::flash('errors'));
}

$app =new App;


?>			<script type="text/javascript"></script>
			<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    		<script src="css/bootstrap/js/bootstrap.min.js"></script>
		</div>    	
  	</body>
</html>