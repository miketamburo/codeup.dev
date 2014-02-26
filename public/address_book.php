<?php
// set file name of csv file and set variables
$address_book = "data/address_book.csv";
$errorMessage = '';
$addressArray = array();
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
		// foreach ($address_book as $fields) {
			fputcsv($handle, $addressArray);
		// }
	fclose($handle);
}

$addressArray = loadCSV($address_book);
// Name Field
if (isset($_POST['personName']) && !empty($_POST['personName'])){
    $personName = ucwords(htmlspecialchars(strip_tags($_POST['personName'])));
       
} else {
	$errorMessage = "Required field empty.  Please complete your entry.";
}
// Address Field
if (isset($_POST['address']) && !empty($_POST['address'])){
    $address = ucwords(htmlspecialchars(strip_tags($_POST['address'])));
       
} else {
	$errorMessage = "Required field empty.  Please complete your entry.";
}
// City Field
if (isset($_POST['city']) && !empty($_POST['city'])){
    $city = ucwords(htmlspecialchars(strip_tags($_POST['city'])));
       
} else {
	$errorMessage = "Required field empty.  Please complete your entry.";
}
// State Field
if (isset($_POST['state']) && !empty($_POST['state'])){
    $state = ucwords(htmlspecialchars(strip_tags($_POST['state'])));
       
} else {
	$errorMessage = "Required field empty.  Please complete your entry.";
}
// Zip Field
if (isset($_POST['zip']) && !empty($_POST['zip'])){
    $zip = (htmlspecialchars(strip_tags($_POST['zip'])));
       
} else {
	$errorMessage = "Required field empty.  Please complete your entry.";
}
// Phone Field
if (isset($_POST['phone']) && !empty($_POST['phone'])){
    $phone = (htmlspecialchars(strip_tags($_POST['phone'])));      
} 

if ((isset($_POST['personName']) && !empty($_POST['personName'])) && (isset($_POST['address']) && !empty($_POST['address'])) && (isset($_POST['city']) && !empty($_POST['city'])) && (isset($_POST['state']) && !empty($_POST['state'])) && (isset($_POST['zip']) && !empty($_POST['zip']))){

//$newEntryArray = ['personName' => $personName, 'address' => $address, 'city' => $city, 'state' => $state, 'zip' => $zip, 'phone' => $phone];
$newEntryArray = [$personName, $address, $city, $state, $zip, $phone];

$addressArray = array_merge($addressArray, $newEntryArray);
saveCSV($addressArray);
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
<!-- 	<? //if (count($address_book) > 0): ?>	 -->
			<ul>
				<? foreach($addressArray as $key => $field): ?>
					<? if (!empty($field)): ?>
					<tr><?= ($field); ?>&nbsp; &nbsp;</tr>
					<? endif; ?>
				<? endforeach; ?>		
			</ul>
<!-- 		<? //else: ?>You have 0 address entries<? //endif; ?> -->
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