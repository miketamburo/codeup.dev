<?php
// The To Do List Project using mysql 
$errorMessage = "";
// ====================================================================================
// Get new instance of MySQLi object
$mysqli = @new mysqli('127.0.0.1', 'mike', 'password', 'todo_db');
// Check for errors
if ($mysqli->connect_errno) {
    echo 'Failed to connect to MySQL: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error;
} else {
  echo $mysqli->host_info . "\n";
}

// sort the list 
if (isset($_GET['sort_col']) && isset($_GET['sort_order'])){
  $sortCol = $_GET['sort_col'];
  $sortOrd = $_GET['sort_order'];  
  $result = $mysqli->query("SELECT * FROM todo_db ORDER BY $sortCol $sortOrd"); 
} else {
  $result = $mysqli->query("SELECT * FROM todo_db"); 
}

// create prepard statements ===============================================
if ((isset($_POST['thing_to_do'])) && (!empty($_POST['thing_to_do'])))
{
// prepare the statement - use ? as placeholder =====================================================
	$stmt = $mysqli->prepare("INSERT INTO todo_db (thing_to_do) VALUES (thing_to_do = ?)");

// bind the parameters of the statement
	$stmt->bind_param("ssssd", $_POST['thing_to_do']);       

// execute the insert
	$stmt->execute();

} elseif ((empty($_POST))) {
  $errorMsg = ' ';
} elseif ((isset($_POST)) && (empty($_POST['thing_to_do']))){
  $errorMsg = "Error:  Unable to update the list due to an empty field submission.";
}        

try {
// Add an item to the list
	if (isset($_POST['thing_to_do'])){

	    $checkValue = $_POST['thing_to_do'];
	    if ((strlen($checkValue) < 240) && !empty($_POST['thing_to_do'])){
	    	$item = ucfirst(htmlspecialchars(strip_tags($checkValue)));
	    	array_push($items, $item);
		
// INSERT ITEMS TO DATABASE //////

	    } else {
	    	throw new InvalidInputException ('No item entered or value is longer than 240 characters');
	    }   	   
	}
} catch (InvalidInputException $e) {
	if (empty($_POST['thing_to_do'])){
		echo $e->getMessage() . PHP_EOL;
	}	
}

// Remove an item from the list
if (isset($_GET['remove'])) {
	$key = $_GET['remove'];
// Save completed items to an archive file (AT THE END OF THE FILE)
	$archiveArray = $class->read($archiveFile);
	array_push($archiveArray, $items[$key]);
		
// Remove item from list and save new todo list

	header("Location: todo-listViaDB.php");	
}
///////////////////////////////////////////////////////////////////////////
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Pal it">
    <meta name="author" content="Michael Tamburo">
    
	<title>To Do List</title>

  <link rel="shortcut icon" href="/css/bootstrap-3.1.1/docs/assets/ico/favicon.ico">
	<link href="/css/bootstrap-3.1.1/css/bootstrap.min.css" rel="stylesheet" >
	<link href="/css/bootstrap-3.1.1/docs/examples/carousel/carousel.css" rel="stylesheet">
	<link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
	<link href="/css/national_parks.css" rel="stylesheet">
</head>
<!-- NAVBAR ============================================================================ -->
<body>
    <div class="navbar-wrapper">      
      <div class="container">
        <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">          
          <div class="container">
            <div class="navbar-header">
              <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
              </button><h3 class="whiteletters" class="navbar-brand">To Do List</h3><h4><?=$errorMsg ?></h4>
            </div>
            <!-- End of navbar header ===========-->
            </div>
            <!-- End of navbar collapse info ===========-->
          </div><!-- /. container ========-->
        </div>
        <!-- End of Navbar features ================-->
      </div>
    </div><!-- End of Navbar Wrapper =================-->
<!-- ================================================== -->
<div class="padding">
  <div>
  	//////////////////////
<ul>
<? foreach($todoList as $key => $item): ?>
	<li><?= $item; ?> <button onclick="removeById(<?= $key; ?>)">Remove</button></li>
<? endforeach; ?>
</ul>
 
<form id="removeForm" action="todo-db.php" method="post">
	<input id="removeId" type="hidden" name="remove" value="">
</form>
 
<script>
	
	var form = document.getElementById('removeForm');
	var removeId = document.getElementById('removeId');
 
	function removeById(id) {
		removeId.value = id;
		form.submit();
	}
</script>
/////////////////////////////////////////////////
		<h2 class=center></h2>
			<p class=center>Enter your item and choose your option.</p>
				<form method="POST" action="">
					<label for='thing_to_do'> Item to add: </label>
        			<input id="thing_to_do" name="thing_to_do" type="text" autofocus = 'autofocus' placeholder="Enter new item" style="width:200px;">
			        <input type="submit" value="Add item" />
				</form>
			<? if (!empty($errorMessage)):?> <?=$errorMessage; endif; ?>
  	////////////////////////////////////////////////
  </div>  
  <table class="table">
      <tr>
          <th scope="col">Item sort
              <a href="?sort_col=thing_to_do&sort_order=ASC"><i class="fa fa-chevron-up"></i></a>
              <a href="?sort_col=thing_to_do&sort_order=DESC"><i class="fa fa-chevron-down"></i></a>
          </th>
      </tr>
      <? while ($row = $result->fetch_array(MYSQLI_ASSOC)): ?>
         <tr> 
          <td><?=$row['thing_to_do']; ?></td>
        </tr>
      <? endwhile; ?>
  </table>
</div>

<!-- ============================================================================================ -->
<div class="navbar navbar-inverse navbar-fixed-bottom" role="navigation">
          
    <div class="container">

      <!-- FOOTER ==============================================================================-->
      <footer>
        <p class="whiteletters">&copy; 2014 Michael Tamburo All rights reserved.</p>
      </footer>

    </div><!-- /.container -->

</div>
    <!-- Bootstrap core JavaScript ===================================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="css/bootstrap-3.1.1/js/bootstrap.min.js"></script>
    <script src="css/bootstrap-3.1.1/docs/assets/js/docs.min.js"></script>
  </body>
</html>




