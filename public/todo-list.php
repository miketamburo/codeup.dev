<?php
// open and read a text file and return an array
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

if (isset($_POST['enter_item']) && !empty($_POST['enter_item'])){
    $item = ucfirst($_POST['enter_item']);
    array_push($items, $item);
   

	saveFile($filename, $items);    
}

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
				<?php 
				foreach($items as $key => $item){
					if (!empty($item)){
					echo "<li>$item <a href=\"?remove=$key\">Mark Complete</a></li>";
					}
				}
				?>
			</ul>

			<p>Enter your item or choose your option.</p>	

			<form method="POST" action="">
				<p> 
					<p>
	        			<input id="enter_item" name="enter_item" type="text" autofocus = 'autofocus' placeholder="Enter new item" style="width:200px;">
				        <input type="submit" value="Add item" />
				    </p>
				</p>
			</form>

	</body>
</html>





