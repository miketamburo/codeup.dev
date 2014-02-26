<?php
// set file name of csv file and set variables
$errorMessage = '';
$newEntryArray = array();
$personName = '';
$address = '';
$city = '';
$state = '';
$zip = '';
$phone = '';
$filename = "data/address_book.csv";

function loadCSV($filename){
	$contents = [];
	$handle = fopen($filename, 'r');
	while(($data = fgetcsv($handle)) !== FALSE) {
  	$contents[] = $data;
	}
	fclose($handle);
	return $contents;
}

// created a function for saving a CSV file
function saveCSV($address_book){
	$handle = fopen('data/address_book.csv', 'w');
		foreach ($address_book as $fields) {
			fputcsv($handle, $fields);
		}
	fclose($handle);
}

$address_book = loadCSV($filename);
// Name Field
if (!empty($_POST)){
    $personName = ucwords(htmlspecialchars(strip_tags($_POST['personName'])));       
    $address = ucwords(htmlspecialchars(strip_tags($_POST['address'])));      
    $city = ucwords(htmlspecialchars(strip_tags($_POST['city'])));      
    $state = ucwords(htmlspecialchars(strip_tags($_POST['state'])));       
    $zip = (htmlspecialchars(strip_tags($_POST['zip'])));      	
    $phone = (htmlspecialchars(strip_tags($_POST['phone'])));      

	$newEntryArray = [$personName, $address, $city, $state, $zip, $phone];
	array_push($address_book, $newEntryArray);
	saveCSV($address_book);

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
			<? if (count($address_book) > 0): ?>
			
			<table>
				<tr>
					<td>Contact</td><td>Address</td><td>City</td><td>State</td><td>Zip Code</td><td>Phone Number</td>
				</tr>
			
				<? foreach($address_book as $field): ?>
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