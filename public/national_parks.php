<?php
// Get new instance of MySQLi object
$mysqli = @new mysqli('127.0.0.1', 'mike', 'password', 'codeup_mysqli_test_db');
$errorMsg = ' ';
// Check for errors
if ($mysqli->connect_errno) {
    echo 'Failed to connect to MySQL: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error;
} else {
  echo $mysqli->host_info . "\n";
}

// create prepard statements ===============================================

if (!empty($_POST['name']) && 
  !empty($_POST['location']) &&
  !empty($_POST['description']) && 
  !empty($_POST['date_established']) &&
  !empty($_POST['area_in_acres']))
{
  // prepare the statement - use ? as placeholder =====================================================
  $stmt = $mysqli->prepare("INSERT INTO national_parks (name, location, description, date_established, area_in_acres) VALUES 
    (?, ?, ?, ?, ?)");
  // bind the parameters of the statement
  $stmt->bind_param("ssssd", $_POST['name'], $_POST['location'], $_POST['description'], $_POST['date_established'], $_POST['area_in_acres']);       
  // execute the insert
  $stmt->execute();
} elseif ((empty($_POST))) {
  $errorMsg = ' ';
} elseif (isset($_POST) &&
   empty($_POST['name']) || 
   empty($_POST['location']) ||
   empty($_POST['description']) || 
   empty($_POST['date_established']) ||
   empty($_POST['area_in_acres']))
{
  $errorMsg = "Error:  Unable to update the list due to an empty field submission.";
} 

///// BEGIN VALIDATION CODE 
$validCols = array('name', 'location', 'date_established');

$sortCol = 'name';
$sortOrd = 'ASC';

if (isset($_GET['sort_col']) && in_array($_GET['sort_col'], $validCols))
{
  $sortCol = $_GET['sort_col'];
}

if (isset($_GET['sort_order']) && $_GET['sort_order'] == 'DESC')
{
  $sortOrd = 'DESC';
}

$result = $mysqli->query("SELECT * FROM national_parks ORDER BY $sortCol $sortOrd");
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
    
	<title>National Parks</title>

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
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse"></button>
                        <h3 class="whiteletters" class="navbar-brand">National Parks</h3>
                        <h4><?=$errorMsg ?></h4>
                    </div><!-- End of navbar header ===========-->
                </div><!-- End of navbar collapse info ===========-->
            </div><!-- /. container ========-->
        </div><!-- End of Navbar features ================-->
    </div>
<!-- ================================================== -->
    <div class="padding">
        <div>
            <ul class="nav nav-tabs">
                <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">
                Add A Park!<span class="caret"></span></a>
                <form method="POST" action="national_parks.php" class="dropdown-menu">
                    <ul >
                        <li>
                        <label for='name'> Name: </label>
                        <input id="name" name="name" type="text" autofocus = 'autofocus' tab=1 placeholder="Enter Park Name (Required)" style="width:200px;">
                        </li>
                
                        <li>
                        <label for='location'> Location: </label>
                        <input id='location' name='location' type="text" tab=2 placeholder="Enter location (Required)" style="width:200px;">
                        </li>
               
                        <li>
                        <label for='description'> Description: </label>
                        <input id="description" name="description" type="text" tab=3 placeholder="Enter description (Required)" style="width:200px;">
                        </li>
                
                        <li>
                        <label for='date_established'> Date Est.: </label>
                        <input id="date_established" name="date_established" type="text" tab=4 placeholder="Date est. (Required)" style="width:200px;">
                        </li>
                
                        <li>
                        <label for='area_in_acres'> aread_in_acres: </label>
                        <input id="area_in_acres" name="area_in_acres" type="text" tab=5 placeholder="Enter acreage (Required)" style="width:200px;">
                        </li>
                
                        <li><input type="submit" value="Update Park Roster" /></li>
                    </ul>
                </form>
                </li>
            </ul>
        </div>  
            <table class="table">
                <tr>
                    <th scope="col">Name
                        <a href="?sort_col=name&amp;sort_order=ASC"><i class="fa fa-chevron-up"></i></a>
                        <a href="?sort_col=name&amp;sort_order=DESC"><i class="fa fa-chevron-down"></i></a>
                    </th>
                    <th scope="col">Location
                        <a href="?sort_col=location&amp;sort_order=ASC"><i class="fa fa-chevron-up"></i></a>
                        <a href="?sort_col=location&amp;sort_order=DESC"><i class="fa fa-chevron-down"></i></a>
                    </th>
                    <th scope="col">Description</th>
                    <th scope="col">Date Established
                        <a href="?sort_col=date_established&amp;sort_order=ASC"><i class="fa fa-chevron-up"></i></a>
                        <a href="?sort_col=date_established&amp;sort_order=DESC"><i class="fa fa-chevron-down"></i></a>
                    </th>
                    <th scope="col">Area in Acres</th>
                </tr>

                <? while ($row = $result->fetch_array(MYSQLI_ASSOC)): ?>
                    <tr> 
                      <td><?=$row['name']; ?></td>
                      <td><?=$row['location']; ?></td>
                      <td><?=$row['description']; ?></td>
                      <td><?=$row['date_established']; ?></td>
                      <td><?=$row['area_in_acres']; ?></td>
                    </tr>
                <? endwhile; ?>
            </table>
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