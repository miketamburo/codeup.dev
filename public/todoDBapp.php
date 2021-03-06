<?php

$errorMessage = null;
$successMessage = null;

// Get new instance of MySQLi object
$mysqli = @new mysqli('127.0.0.1', 'mike', 'password', 'todo_db');

// Check for errors
if ($mysqli->connect_errno) {
    throw new Exception('Failed to connect to MySQL: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
} 

if (!empty($_POST)){
	// check for new todo
	if (isset($_POST['todo'])){
		if ($_POST['todo'] != ""){

			$todo = substr($_POST['todo'], 0, 200);
			// add todo 
			$stmt = $mysqli->prepare("INSERT INTO todos (item) VALUES (?);");
  			// bind the parameters of the statement
  			$stmt->bind_param("s", $todo); 
			$stmt->execute();

			$successMessage = "Todo item was added successfully.";
		} else {
			// show error message
			$errorMessage = "Please input a todo item";
		}
	} elseif (!empty($_POST['remove'])){
		
		// remove item from database
		$stmt = $mysqli->prepare("DELETE FROM todos WHERE id = ?;");
		// bind the parameters of the statement
		$stmt->bind_param("i", $_POST['remove']); 
		$stmt->execute();

		$successMessage = "Todo item was removed successfully.";
	}
}

$itemsPerPage = 2;
$currentPage = !empty($_GET['page']) && is_numeric($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($currentPage - 1) * $itemsPerPage;

$todos = $mysqli->query("SELECT * FROM todos LIMIT $itemsPerPage OFFSET $currentPage;");
$allTodos = $mysqli->query("SELECT * FROM todos;");

$maxPage = ceil($allTodos->num_rows / $itemsPerPage);

$prevPage = $currentPage > 1 ? $currentPage - 1 : null;
$nextPage = $currentPage < $maxPage ? $currentPage + 1 : null;
 
?>
<html>
<head>
	<title>Todo List</title>
	
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap-theme.min.css">
	<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container"> 
	<? if (!empty($successMessage)): ?>
	<div class="alert alert-success"><?= $successMessage; ?></div>
	<? endif; ?>

	<? if (!empty($errorMessage)): ?>
	<div class="alert alert-danger"><?= $errorMessage; ?></div>
	<? endif; ?>

	<h1>Todo List</h1>
	 
	<table class="table table-striped">
	<? while ($todo = $todos->fetch_assoc()): ?>
		<tr>
			<td><?= $todo['item']; ?></td>
			<td><button class="btn btn-danger btn-sm pull-right" onclick="removeById(<?= $todo['id']; ?>)">Remove</button></td>
		</tr>
	<? endwhile; ?>
	</table>
	<div class="clearfix">
		<? if ($prevPage != null): ?>
			<a href="?page=<?= $prevPage; ?>" class="pull-left btn btn-default btn-sm">&lt; Previous</a> 
		<? endif; ?>
 
		<? if ($nextPage != null): ?>
			<a href="?page=<?= $nextPage; ?>" class="pull-right btn btn-default btn-sm">Next &gt;</a> 
		<? endif; ?>
	</div>

	<h2>Add Items</h2>
	<form class="form-inline" role="form" action="todoDBapp.php" method="POST">
  		<div class="form-group">
    		<label class="sr-only" for="todo">Enter item</label>
    		<input type="text" name="todo" class="form-control" id="todo" placeholder="Enter todo item">
  		</div>

  		<button type="submit" class="btn btn-default">Add Todo</button>
  		
	</form>

</div>
 
<form id="removeForm" action="todoDBapp.php" method="post">
	<input id="removeId" type="hidden" name="remove" value="">
</form>
 
<script>
	
	var form = document.getElementById('removeForm');
	var removeId = document.getElementById('removeId');
 
	function removeById(id) {
		if (confirm('Are you sure you want to remove the item ' + id + '?')){
			removeId.value = id;
			form.submit();
		}
	}
 
</script>
 
</body>
</html>