<?php
// set file name of csv file and set variables
$address_book = "data/address_book.csv";
$errorMessage = '';
$addressArray = [
    ['The White House', '1600 Pennsylvania Avenue NW', 'Washington', 'DC', '20500'],
    ['Marvel Comics', 'P.O. Box 1527', 'Long Island City', 'NY', '11101'],
    ['LucasArts', 'P.O. Box 29901', 'San Francisco', 'CA', '94129-0901']];
$newEntryArray = array();
$personName = '';
$address = '';
$city = '';
$state = '';
$zip = '';
$phone = '';

// function loadCSV($address_book){
// 	$handle = fopen($address_book, "r");
// 	$filesize = filesize($address_book);
// 	$contents = fgetcsv($handle, $filesize);
// 	fclose($handle);
// }

// created a function for saving a CSV file
function saveCSV($addressArray){
	$handle = fopen('data/address_book.csv', 'a');
		foreach ($addressArray as $fields) {
			fputcsv($handle, $fields);
		}
	fclose($handle);
}
// $addressArray = loadCSV($address_book);
// Name Field
if (isset($_POST['personName']) && !empty($_POST['personName'])){
    $personName = ucwords(htmlspecialchars(strip_tags($_POST['personName'])));       
} 
// Address Field
if (isset($_POST['address']) && !empty($_POST['address'])){
    $address = ucwords(htmlspecialchars(strip_tags($_POST['address'])));      
} 
// City Field
if (isset($_POST['city']) && !empty($_POST['city'])){
    $city = ucwords(htmlspecialchars(strip_tags($_POST['city'])));      
} 
// State Field
if (isset($_POST['state']) && !empty($_POST['state'])){
    $state = ucwords(htmlspecialchars(strip_tags($_POST['state'])));       
} 
// Zip Field
if (isset($_POST['zip']) && !empty($_POST['zip'])){
    $zip = (htmlspecialchars(strip_tags($_POST['zip'])));      
} 
// Phone Field
if (isset($_POST['phone']) && !empty($_POST['phone'])){
    $phone = (htmlspecialchars(strip_tags($_POST['phone'])));      
} 

if (!empty($_POST['personName']) && !empty($_POST['address']) && !empty($_POST['city']) && !empty($_POST['state']) && !empty($_POST['zip'])){
//$newEntryArray = ['personName' => $personName, 'address' => $address, 'city' => $city, 'state' => $state, 'zip' => $zip, 'phone' => $phone];
	$newEntryArray = [$personName, $address, $city, $state, $zip, $phone];
	array_push($addressArray, $newEntryArray);
	saveCSV($addressArray);
	
} else {
	$errorMessage = "Required field empty.  Please complete your entry before submitting.";
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
			<? if (count($addressArray) > 0): ?>
			
			<table>
				<tr>
					<td>Contact</td><td>Address</td><td>City</td><td>State</td><td>Zip Code</td><td>Phone Number</td>
				</tr>
			
				<? foreach($addressArray as $field): ?>
					<? if (!empty($field)): ?>
						<tr>
							<? foreach ($field as $item): ?>
								<td><?= $item; ?></td>
							<? endforeach; ?>	
						</tr>
					<? endif; ?>
				<? endforeach; ?>		
			</table>
			
			<? else: ?>You have 0 entries.<? endif; ?>
	<hr/>
	<? if (!empty($errorMessage)):?> <?=$errorMessage; endif; ?>
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