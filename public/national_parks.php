<?php
// Get new instance of MySQLi object
$mysqli = @new mysqli('127.0.0.1', 'mike', 'password', 'codeup_mysqli_test_db');

// Check for errors
if ($mysqli->connect_errno) {
    echo 'Failed to connect to MySQL: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error;
} else {
  echo $mysqli->host_info . "\n";
}

if (isset($_GET['sort_col']) && isset($_GET['sort_order'])){
  $sortCol = $_GET['sort_col'];
  $sortOrd = $_GET['sort_order'];  
  $result = $mysqli->query("SELECT * FROM national_parks ORDER BY $sortCol $sortOrd"); 
} else {
  $result = $mysqli->query("SELECT * FROM national_parks"); 
}
// prepared statements
// $stmt = $mysqli->prepare("SELECT name, location, description, date_established, area_in_acres FROM national_parks 
//   WHERE name = ?, location = ?, description = ?, date_established = ?, area_in_acres = ?");

// $stmt->bind_param("ssssd", 'name', 'location', 'description', 'date_established', 'area_in_acres');

// $stmt->execute();

// $stmt->bind_result($name, $location, $description, $date_established, $area_in_acres);
// // code for html section
// while ($stmt->fetch()){
//   echo $name . PHP_EOL;
// }

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
              <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
              </button><h3 class="whiteletters" class="navbar-brand">National Parks</h3>
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
      <ul class="nav nav-tabs">
        <li class="dropdown">
          <a class="dropdown-toggle" data-toggle="dropdown" href="#">
            Add A Park!<span class="caret"></span>
          </a>
          <ul class="dropdown-menu">
            <form class="navbar-form navbar-left" role="search">
              <div class="form-group">
                <input type="text" class="form-control" placeholder="Park Name">
                <input type="text" class="form-control" placeholder="Location">
                <input type="text" class="form-control" placeholder="Description">
                <input type="text" class="form-control" placeholder="Date est. YYYY-MM-DD">
                <input type="text" class="form-control" placeholder="Area In Acres">
              </div>
              <button type="submit" class="btn btn-default">Apply Info</button>
            </form>
          </ul>
        </li>
      </ul>
  </div>  
  <table class="table">
      <tr>
          <th scope="col">Number</th>
          <th scope="col">Name
              <a href="?sort_col=name&sort_order=ASC"><i class="fa fa-chevron-up"></i></a>
              <a href="?sort_col=name&sort_order=DESC"><i class="fa fa-chevron-down"></i></a>
          </th>
          <th scope="col">Location
              <a href="?sort_col=location&sort_order=ASC"><i class="fa fa-chevron-up"></i></a>
              <a href="?sort_col=location&sort_order=DESC"><i class="fa fa-chevron-down"></i></a>
          </th>
          <th scope="col">Description</th>
          <th scope="col">Date Established
              <a href="?sort_col=date_established&sort_order=ASC"><i class="fa fa-chevron-up"></i></a>
              <a href="?sort_col=date_established&sort_order=DESC"><i class="fa fa-chevron-down"></i></a>
          </th>
          <th scope="col">Area in Acres</th>
      </tr>
      <? while ($row = $result->fetch_array(MYSQLI_ASSOC)): ?>
         <tr> 
          <td><?=$row['id']; ?></td>
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