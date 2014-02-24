<?php

$items = array();
$filename = "data/todoitems.txt";

if (isset($_POST['save_item']) && $_POST['save_item'] == "yes"){
    $handle = fopen($filename, "w");
    $items = array_push($items, $_POST['enter_item']);
    $item = implode("\n", $items);
    fwrite($handle, $item);
    fclose($handle);
} 

$handle = fopen($filename, "r");
$contents = fread($handle, filesize($filename));
fclose($handle);
$contents_array = explode("\n", $contents);

$items = array_merge($items, $contents_array);

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
				foreach($items as $item){
					if (!empty($item)){
					echo "<li>$item <a href="todo-list.php?remove=x">Mark Complete</a></li>";
					}
				}
				?>
			</ul>

			<p>Enter your item or selection then choose your option.</p>	

			<form method="POST" action="">
				<p> 
					<p>
	        			<label for="enter_item">Enter Item:</label>
	        			<textarea id="enter_item" name="enter_item" rows="1" cols="30"></textarea>
	    			</p>
	    			<p>
	    				<label for = "save_item">
	    				<input type="checkbox" id="save_item" name="save_item" value="yes" checked> Save item
	    				</label>
	    			</p>
				    <p>
				        <input type="submit" value="save" />
				    </p>
					</p>
			</form>

	</body>
</html>





