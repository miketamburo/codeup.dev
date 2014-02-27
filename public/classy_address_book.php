<?php
// set error variables
$nameError = '';
$addressError = '';
$cityError = '';
$stateError = '';
$zipError = '';
$errorArray = array();
$errorMessage = '';
// set other variables
$newEntryArray = array();
$personName = '';
$address = '';
$city = '';
$state = '';
$zip = '';
$phone = '';
$fileUploadError = '';
// establish a class
class AddressDataStore {
	public $filename = '';
	public $entries = array();

	function __construct($filename = "data/address_book.csv"){
		$this->filename = $filename;
	}

	function read_address_book() {
		$contents = [];
		$handle = fopen($this->filename, 'r');
		while(($data = fgetcsv($handle)) !== FALSE) {
	  	$contents[] = $data;
		}
		fclose($handle);
		return $contents;
	}

	function write_address_book() {
		$handle = fopen($this->filename, 'w');
			foreach ($this->entries as $entry) {
				fputcsv($handle, $entry);
			}
		fclose($handle);
	}
	// Push a new entry onto the $entries array
	function addEntry(AddressEntry $entry){
		array_push($this->entries, $entry);

	}
	// Remove a given entry from the $entries array
	function removeEntry($index){
		if (isset($_GET[$index])) {
		$this->$key = $_GET[$index];	
	// Remove item from list and save new list
		unset($entries[$this->$key]);
		$this->write_address_book($entries);

		header("Location: classy_address_book.php");
		exit;	
		}
	}
	// Merge a second AddressDataStore into this one
	function mergeAddressBooks(AddressDataStore $book) {

	}	
}

class AddressEntry {
	public $name;
	public $address;
	public $city;
	public $state;
	public $zip;
	public $phone;

	public $errors = array();

	//Take in array from CSV or POST & assign values
	function __construct(array $values = array()){

	}

	// Return boolean:  is entry valid?
	function validate(){
		$this->$fieldName = $fieldName;
		if (!empty($_POST['$fieldName'])){
			return TRUE;         
		} 
	}

	// Return values as an array for CSV output
	function getArray(){

	}

}
$book = new AddressDataStore();

$entries = $book->read_address_book();

// Name Field
if (isset($_POST['personName']) && !empty($_POST['personName'])){
    $personName = ucwords(htmlspecialchars(strip_tags($_POST['personName'])));       
} else {
	$nameError = "The name field is required but empty.";
}
// Address Field
if (isset($_POST['address']) && !empty($_POST['address'])){
    $address = ucwords(htmlspecialchars(strip_tags($_POST['address'])));      
} else {
	$addressError = "The address field is required but empty.";
}
// City Field
if (isset($_POST['city']) && !empty($_POST['city'])){
    $city = ucwords(htmlspecialchars(strip_tags($_POST['city'])));      
} else {
	$cityError = "The city field is required but empty.";
}
// State Field
if (isset($_POST['state']) && !empty($_POST['state'])){
    $state = ucwords(htmlspecialchars(strip_tags($_POST['state'])));       
} else {
	$stateError = "The state field is required but empty.";
}
// Zip Field
if (isset($_POST['zip']) && !empty($_POST['zip'])){
    $zip = (htmlspecialchars(strip_tags($_POST['zip'])));      
} else {
	$zipError = "The zip field is required but empty.";
}
// Phone Field
if (isset($_POST['phone']) && !empty($_POST['phone'])){
    $phone = (htmlspecialchars(strip_tags($_POST['phone'])));      
} 

if (!empty($_POST['personName']) && !empty($_POST['address']) && !empty($_POST['city']) && !empty($_POST['state']) && !empty($_POST['zip'])){
//$newEntryArray = ['personName' => $personName, 'address' => $address, 'city' => $city, 'state' => $state, 'zip' => $zip, 'phone' => $phone];
	$newEntryArray = [$personName, $address, $city, $state, $zip, $phone];
	array_push($entries, $newEntryArray);
	$book->write_address_book($entries);

} else {
	$errorMessageArray = [$nameError, $addressError, $cityError, $stateError, $zipError];
}

if (count($_FILES) > 0 && $_FILES['fileUpLoad']['error'] == 0 && $_FILES['fileUpLoad']['type'] == 'text/csv') {
    // Set the destination directory for uploads
    $upload_dir = '/vagrant/sites/codeup.dev/public/uploads/';
    // Grab the filename from the uploaded file by using basename
    $uploadfilename = basename($_FILES['fileUpLoad']['name']);
    // Create the saved filename using the file's original name and our upload directory
    $saved_filename = $upload_dir . $uploadfilename;
    // Move the file from the temp location to our uploads directory
    move_uploaded_file($_FILES['fileUpLoad']['tmp_name'], $saved_filename);

	$book->filename = ($saved_filename);
	$entries = $book->read_address_book();

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
			<? if (count($entries) > 0): ?>
			
			<table>
				<tr>
					<td>Contact</td><td>Address</td><td>City</td><td>State</td><td>Zip Code</td><td>Phone Number</td>
				</tr>
			
				<? foreach($entries as $key => $field): ?>
					<? if (!empty($field)): ?>
						<tr>
							<? foreach ($field as $item): ?>
								<td><?= $item; ?></td>
							<? endforeach; ?>	
						<td><a href="?remove=<?= $key; ?>">Delete Contact</a></td></tr>
					<? endif; ?>
				<? endforeach; ?>		
			</table>
			
			<? else: ?>You have 0 entries.<? endif; ?>
	<hr>
	<? if (!empty($errorMessageArray) && !empty($_POST)):?> 
		<? foreach ($errorMessageArray as $message): ?>
			<p style="color: red"><?=$message; ?></p>
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