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
// establish a class
class AddressDataStore {
	public $filename = '';

	function read_address_book() {
		$contents = [];
		$handle = fopen($this->filename, 'r');
		while(($data = fgetcsv($handle)) !== FALSE) {
	  	$contents[] = $data;
		}
		fclose($handle);
		return $contents;
	}

	function write_address_book($addresses_array) {
		$handle = fopen($this->filename, 'w');
			foreach ($addresses_array as $fields) {
				fputcsv($handle, $fields);
			}
		fclose($handle);
	}
	
}
$book = new AddressDataStore();

$book->filename = "data/address_book.csv";

$addresses_array = $book->read_address_book();


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
	array_push($addresses_array, $newEntryArray);
	$book->write_address_book($addresses_array);

} else {
	$errorMessageArray = [$nameError, $addressError, $cityError, $stateError, $zipError];
}

if (isset($_GET['remove'])) {
	$key = $_GET['remove'];	
// Remove item from list and save new todo list
	unset($addresses_array[$key]);
	$book->write_address_book($addresses_array);

	header("Location: address_book.php");
	exit;	
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


</body>
</html>