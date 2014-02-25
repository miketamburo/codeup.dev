<?php
// open and read a text file and return an array
$newItems = array();
$errorMessage = '';

function loadFile($filename){
	$handle = fopen($filename, "r");
	$filesize = filesize($filename);

	if ($filesize > 0){
	
		$contents = fread($handle, $filesize);
		fclose($handle);
		return explode("\n", $contents);
	} else {
		fclose($handle);
		return array();
	}
	
}
// save string to text file
function saveFile($filename, $items){
	$itemStr = implode("\n", $items);
	$handle = fopen($filename, "w");
	fwrite($handle, $itemStr);
	fclose($handle);
}

$filename = "data/todoitems.txt";
$items = loadFile($filename);
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

	$newItems = loadFile($saved_filename);

    if (isset($_POST['overwrite']) && ($_POST['overwrite']) == 'yes'){
    	$filename = "data/todoitems.txt";
    	saveFile($filename, $newItems);
    	$items = $newItems;
    } elseif (!isset($_POST['overwrite'])){
    	
		$items = array_merge($items, $newItems);
		saveFile($filename, $items);
	}
} else {
	$errorMessage = "Error:  Text file not recognized.  Upload halted.";
}

// Check if we saved a file
if (isset($saved_filename)) {
    // If we did, show a link to the uploaded file
    echo "<p>You can download your file <a href='/uploads/{$filename}'>here</a>.</p>";
}

// Add an item to the list
if (isset($_POST['enter_item']) && !empty($_POST['enter_item'])){
    $item = ucfirst($_POST['enter_item']);
    array_push($items, $item);
   
	saveFile($filename, $items);    
}

// Remove an item from the list
if (isset($_GET['remove'])) {
	$key = $_GET['remove'];
	unset($items[$key]);

	saveFile($filename, $items);

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
			<ul>
				<? foreach($items as $key => $item): ?>
					<? if (!empty($item)): ?>
					<li><?= htmlspecialchars(strip_tags($item)); ?><a href="?remove=<?= $key; ?>">Mark Complete</a></li>
					<? endif; ?>
				
				<? endforeach; ?>
			</ul>

			<p>Enter your item or choose your option.</p>	

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

	</body>
</html>





