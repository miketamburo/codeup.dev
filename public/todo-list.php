<?php
// open and read a text file and return an array
$newItems = array();
$errorMessage = "";
$archiveArray = array();
$archiveFile = "data/archivetodo.txt";
$filename = "data/todoitems.txt";

require_once('filestore.php');



$class = new Filestore($filename);
// Create array to hold list of todo items

$items = $class->read();


//File to upload script
// Verify there were uploaded files and no errors
if (count($_FILES) > 0 && $_FILES['fileUpLoad']['error'] == 0 && $_FILES['fileUpLoad']['type'] == 'text/plain') {
    // Set the destination directory for uploads
    $upload_dir = '/vagrant/sites/codeup.dev/public/uploads/';
    // Grab the filename from the uploaded file by using basename
    $uploadfilename = basename($_FILES['fileUpLoad']['name']);
    // Create the saved filename using the file's original name and our upload directory
    $saved_filename = $upload_dir . $uploadfilename;
    // Move the file from the temp location to our uploads directory
    move_uploaded_file($_FILES['fileUpLoad']['tmp_name'], $saved_filename);

    $class2 = new Filestore($saved_filename);
	$newItems = $class2->read();

    if (isset($_POST['overwrite']) && ($_POST['overwrite']) == 'yes'){
    	$items = $newItems;
    	$class->write($items);

    } elseif (!isset($_POST['overwrite'])){
		
		$items = array_merge($items, $newItems);
		$class->filename = $filename;
		$class->write($items);
	}

} elseif (isset($_FILES['fileUpLoad']) && $_FILES['fileUpLoad']['type'] != 'text/plain') {
	$errorMessage = "Error:  Text file not recognized.  Upload halted.";
}

// Check if we saved a file
if (isset($saved_filename)) {
    // If we did, show a link to the uploaded file
    echo "<p>You can download your file <a href='/uploads/{$filename}'>here</a>.</p>";
}

// Add an item to the list
if (isset($_POST['enter_item']) && !empty($_POST['enter_item'])){
    $item = ucfirst(htmlspecialchars(strip_tags($_POST['enter_item'])));
    array_push($items, $item);
   
	$class->write($items);    
}

// Remove an item from the list
if (isset($_GET['remove'])) {
	$key = $_GET['remove'];
// Save completed items to an archive file (AT THE END OF THE FILE)
	$archiveArray = $class->read($archiveFile);
	array_push($archiveArray, $items[$key]);
	$class->write($archiveFile);
	
// Remove item from list and save new todo list
	unset($items[$key]);
	$class->write($items);

	header("Location: todo-list.php");
	exit;	
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>TODO List</title>
</head>
	<body>
		<h2>TODO List</h2>
			<p>Enter your item and choose your option.</p>
			<? if (count($items) > 0): ?>	
			<ul>
				<? foreach($items as $key => $item): ?>
					<? if (!empty($item)): ?>
					<li><?= ($item); ?> &nbsp;&nbsp;&nbsp; <a href="?remove=<?= $key; ?>">Mark Complete</a></li>
					<? endif; ?>
				<? endforeach; ?>		
			</ul>
		<? else: ?>You have 0 TODO Items<? endif; ?>

			<form method="POST" action="">
				<p> 
					<p>
						<label for='enter_item'> Item to add: </label>
	        			<input id="enter_item" name="enter_item" type="text" autofocus = 'autofocus' placeholder="Enter new item" style="width:200px;">
				      
				        <input type="submit" value="Add item" />
				    </p>
			</form>
			<? if (!empty($errorMessage)):?> <?=$errorMessage; endif; ?>
			<form method="POST" enctype="multipart/form-data" action="">
				    <p>
						<label for='fileUpLoad'> File to upload: </label>
	        			<input id='fileUpLoad' name='fileUpLoad' type="file">
	        			<input type="checkbox" id="overwrite" name="overwrite" value="yes" checked> Overwrite existing file
	        			<input type="submit" value="Upload File" />
				    </p>
				</p>
			</form>
			<p> &copy; 2014 A Software Developer(MT) </p>
	</body>
</html>





