<?php
// set error variables
$errorMessage = '';
$errorString = '';
// set other variables
$newEntryArray = array();
$personName = '';
$address = '';
$city = '';
$state = '';
$zip = '';
$phone = '';
$fileUploadError = '';

require('filestore.php');

class AddressDataStore extends Filestore {
	function __construct($filename){
		$this->filename = $filename;
		parent::__construct($this->filename);
	}
}

$book = new AddressDataStore("data/address_book.csv");

$addresses_array = $book->read();

if (isset($_POST)){
	// Name Field
	if (!empty($_POST['personName']) && (strlen($_POST['personName']) < 125)){
	    $personName = ucwords(htmlspecialchars(strip_tags($_POST['personName'])));       
	} elseif (!empty($_POST['personName']) && strlen($_POST['personName']) > 125) {
		throw new Exception ('Value is greater than 125 characters');
	} else {
		$errorString .= 'name ';		
	}	
	// Address Field
	if (!empty($_POST['address']) && strlen($_POST['address']) < 125){
	    $address = ucwords(htmlspecialchars(strip_tags($_POST['address'])));      
	} elseif (!empty($_POST['address']) && strlen($_POST['address']) > 125) {
		throw new Exception ('Value is greater than 125 characters');
	}  else {
		$errorString .= 'address ';
		
	}
	// City Field
	if (!empty($_POST['city']) && strlen($_POST['city']) < 125){
	    $city = ucwords(htmlspecialchars(strip_tags($_POST['city'])));      
	} elseif (!empty($_POST['city']) && strlen($_POST['city']) > 125) {
		throw new Exception ('Value is greater than 125 characters');
	} else {
		$errorString .= 'city';
		
	}
	// State Field
	if (!empty($_POST['state']) && strlen($_POST['state']) < 125){
	    $state = ucwords(htmlspecialchars(strip_tags($_POST['state'])));       
	} elseif (!empty($_POST['state']) && strlen($_POST['state']) > 125) {
		throw new Exception ('Value is greater than 125 characters');
	} else {
		$errorString .= 'state';
		
	}
	// Zip Field
	if (!empty($_POST['zip']) && strlen($_POST['zip']) < 125){
	    $zip = (htmlspecialchars(strip_tags($_POST['zip'])));      
	} elseif (!empty($_POST['zip']) && strlen($_POST['zip']) > 125) {
		throw new Exception ('Value is greater than 125 characters');
	} else {
		$errorString .= 'zip';
		
	}
	// Phone Field
	if (!empty($_POST['phone']) && strlen($_POST['phone']) < 125){
	    $phone = (htmlspecialchars(strip_tags($_POST['phone'])));
	       
	} 
}
// if $errorString is empty then all fields have an entry (except: optional phone) and the file can be saved
if (empty($errorString)){
	$newEntryArray = [$personName, $address, $city, $state, $zip, $phone];
	array_push($addresses_array, $newEntryArray);
	$book->write($addresses_array);

} else {
// Create an error message array for user feedback	
	$errorMessageArray = explode(' ', $errorString);
}

if (isset($_GET['remove'])) {
	$key = $_GET['remove'];	
	// Remove item from list and save new list
	unset($addresses_array[$key]);
	$book->write($addresses_array);
	// reset page to home location
	header("Location: classy_address_book.php");
	exit;	
}
// Check upload file size, load errors, and type.  If all tests pass, then save.
if ((count($_FILES) > 0) && ($_FILES['fileUpLoad']['error'] == 0) && ($_FILES['fileUpLoad']['type'] == 'text/csv')) {
    $upload_dir = '/vagrant/sites/codeup.dev/public/uploads/';
    $uploadfilename = basename($_FILES['fileUpLoad']['name']);
    $saved_filename = $upload_dir . $uploadfilename;
    move_uploaded_file($_FILES['fileUpLoad']['tmp_name'], $saved_filename);
	$book->filename = ($saved_filename);
	$addresses_array = $book->read();

} elseif (isset($_FILES['fileUpLoad']) && $_FILES['fileUpLoad']['type'] != 'text/csv') {
	$fileUploadError = "Error:  File is not a csv file.  Upload halted.";
}

?>

<!DOCTYPE HTML>
<html>
<head>
	<title>Address Book</title>
</head>
<body>
	<h2>Address Book</h2>
	<p></p>
	<h3>Current Address Book Entries</h3>
	<p> </p>
			<? if (count($addresses_array) > 0): ?>
			<table>
				<tr>
					<td>Contact</td><td>Address</td><td>City</td><td>State</td><td>Zip Code</td><td>Phone Number</td>
				</tr>
			
				<? foreach($addresses_array as $key => $field): ?>
					<? if (!empty($field)): ?>
						<tr>
							<? foreach ($field as $item): ?>
								<td><?= $item; ?></td>
							<? endforeach; ?>	
						<td><a href="?remove=<?= $key; ?>">Delete Contact</a></td></tr>
					<? endif; ?>
				<? endforeach; ?>		
					<? else: ?>You have 0 entries.<? endif; ?>
			</table>	
	<hr>
	<? if (!empty($errorMessageArray) && !empty($_POST)):?> 
		<? foreach ($errorMessageArray as $message): ?>
			<p><p style="color: red"> The (<?=$message; ?>) field is empty.  Please complete the form before updating the file.</p>
		<? endforeach; ?>
	<? endif; ?>
	<p></p>
	<form method="POST" action="">
		<label for='personName'> Name: </label>
	    <input id="personName" name="personName" type="text" autofocus = 'autofocus' tab=1 placeholder="Enter First and Last Name (Required)" style="width:200px;">
	    <p></p>
	    <label for='address'> Address: </label>
	    <input id='address' name='address' type="text" tab=2 placeholder="Enter Address (Required)" style="width:200px;">
	    <p></p>
	    <label for='city'> City: </label>
	    <input id="city" name="city" type="text" tab=3 placeholder="Enter City (Required)" style="width:200px;">
	    <p></p>
	    <label for='state'> State: </label>
	    <input id="state" name="state" type="text" tab=4 placeholder="Enter State (Required)" style="width:200px;">
	    <p></p>
	    <label for='zip'> Zip: </label>
	    <input id="zip" name="zip" type="text" tab=5 placeholder="Enter Zip (Required)" style="width:200px;">
	    <p></p>
	    <label for='phone'> Phone: </label>
	    <input id="phone" name="phone" type="text" tab=6 placeholder="(Optional) Enter Phone Number" style="width:200px;">
	    <p></p>
	    <input type="submit" value="Update Address Book" />
	</form>
	<form method="POST" enctype="multipart/form-data" action="">
				    <p>
						<label for='fileUpLoad'> File to upload: </label>
	        			<input id='fileUpLoad' name='fileUpLoad' type="file">
	        			<input type="submit" value="Upload File" />
				    </p>
	</form>
	<? if (!empty($fileUploadError)): ?><p style="color: red"><?=$fileUploadError ?></p><? endif; ?>

</body>
</html>