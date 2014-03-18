<?php
// Get new instance of MySQLi object
$mysqli = @new mysqli('127.0.0.1', 'mike', 'password', 'todo_db');
// set initial variable values
$errorMsg = ' ';
$limit = 10;
// Check for errors
if ($mysqli->connect_errno) {
    echo 'Failed to connect to MySQL: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error;
} else {
  echo $mysqli->host_info . "\n";
}
// Query for total rows ==============================================================
$totalRows = $mysqli->query('SELECT * FROM todo_db');

$num_rows = $totalRows->num_rows;

$num_pages = ceil($num_rows/$limit);

$totalRows->close();

// Calculate the number of pages required and calculate offset ==========================
if (!empty($_GET['page'])){
  $page = $_GET['page'];
} else {
  $page = 1;
}

if ($page > 1){
  $offset = (($_GET['page'] * $limit) - $limit);
} else {
  $offset = 0;
}

// Create prepared statement for data pull =============================================
$stmt = $mysqli->prepare("SELECT * FROM todo_db LIMIT ? OFFSET ?");

// bind params
$stmt->bind_param("ii", $limit, $offset);

// execute the query and return the result
$stmt->execute();

// bind the result
$stmt->bind_result($id, $thing_to_do, $completed);

$rows = array();

while ($stmt->fetch()){
  $rows[] = array('id' => $id, 'thing_to_do' => $thing_to_do, 'completed' => $completed);
}

// create prepared statements for INSERT ===============================================
if (!empty($_POST['thing_to_do']))
{
  // prepare the statement - use ? as placeholder ======================================
  $stmt = $mysqli->prepare("INSERT INTO todo_db (thing_to_do, completed) VALUES (?, ?)");
  // bind the parameters of the statement
  $stmt->bind_param("sd", (htmlspecialchars(strip_tags($_POST['thing_to_do']))), $_POST['completed']);       
  // execute the insert
  $stmt->execute();
} elseif ((empty($_POST))) {
  $errorMsg = ' ';
} elseif (isset($_POST) && empty($_POST['thing_to_do']))
{
  $errorMsg = "Error:  Unable to update the list due to an empty field submission.";
} 

// MARK AN ITEM AS COMPLETE AND REMOVE IT
if (isset($_GET['remove'])){
  // prepare the statement - use ? as placeholder ======================================
  $stmt = $mysqli->prepare("DELETE FROM todo_db WHERE id = ?");
  // bind the parameters of the statement
  $stmt->bind_param("i", $_GET['remove']);       
  // execute the insert
  $stmt->execute();
}

///// BEGIN VALIDATION CODE 
$validCols = array('thing_to_do', 'completed');
// set default values
$sortCol = 'thing_to_do';
$sortOrd = 'ASC';

if (isset($_GET['offset']) && $_GET['offset'] == 10){
  $offset = 10;
}
if (isset($_GET['sort_col']) && in_array($_GET['sort_col'], $validCols))
{
  $sortCol = $_GET['sort_col'];
}
if (isset($_GET['sort_order']) && $_GET['sort_order'] == 'DESC')
{
  $sortOrd = 'DESC';
}

$result = $mysqli->query("SELECT * FROM todo_db ORDER BY $sortCol $sortOrd LIMIT 10 OFFSET $offset");
///// END VALIDATION CODE

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
	  <link href="/css/todo.css" rel="stylesheet">
</head>
<!-- NAVBAR ============================================================================ -->
<body>
    <div class="navbar-wrapper">
        <div class="container">
            <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
                <div class="container">
                    <div class="navbar-header">
                        <h3 class="whiteletters" class="navbar-brand">To Do List</h3>
                        <h4 class="whiteletters"><?=$errorMsg ?></h4>
                    </div><!-- End of navbar header ===========-->
                </div><!-- End of navbar collapse info ===========-->
            </div><!-- /. container ========-->
        </div><!-- End of Navbar features ================-->
    </div>
<!-- ================================================== -->
    <div class="container" style="margin-top: 36px;">
      <form method="POST" action="todo-listViaDB.php"> 
        <table class="table">
            <tr>
                <th scope="col">Item sort
                    <a href="?sort_col=thing_to_do&amp;sort_order=ASC"><i class="fa fa-chevron-up"></i></a>
                    <a href="?sort_col=thing_to_do&amp;sort_order=DESC"><i class="fa fa-chevron-down"></i></a>
                </th>
            </tr>

            <? while ($row = $result->fetch_array(MYSQLI_ASSOC)): ?>
                <tr>
                    <td><?=$row['thing_to_do']; ?></td>
                    <td><a href="?remove=<?=$row['id']?>">Mark Complete</a></td> 
                </tr>
            <? endwhile; ?>

        </table>
        
            <label for='thing_to_do'><h3> Item to add: </h3></label>
            <input id="thing_to_do" name="thing_to_do" type="text" autofocus = 'autofocus' placeholder="Enter new item" style="width:200px;">
            <input type="submit" value="Add item" />
    </form>

        <!-- pager buttons ============================== -->
        <div>
          <ul class="pager">
            <li><a href="?offset=<?=$offset?>">Previous</a></li>
            <li><a href="?offset=<?=$offset + $limit?>">Next 10</a></li>
          </ul>
        </div>


        <!-- ============================================ -->
    </div>

<!-- ================================================== -->
<div class="navbar navbar-inverse navbar-fixed-bottom" role="navigation">
          
    <div class="container">

      <!-- FOOTER ==================================-->
      <footer>
        <p class="whiteletters">&copy; 2014 Michael Tamburo All rights reserved.</p>
      </footer>

    </div><!-- /.container -->

</div>
    <!-- Bootstrap core JavaScript ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="css/bootstrap-3.1.1/js/bootstrap.min.js"></script>
    <script src="css/bootstrap-3.1.1/docs/assets/js/docs.min.js"></script>
  </body>
</html>