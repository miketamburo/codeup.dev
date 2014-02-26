<?php
// set file name of csv file and set variables
$csvFileName = "data/address_book.csv";
$errorMessage = '';
$addressArray = array();
$personName = '';
$address = '';
$city = '';
$state = '';
$zip = '';
$phone = '';

// created a function for saving a CSV file
function saveCSV($csvFileName){
	$handle = fopen('$csvFileName', 'w');
		foreach ($address_book as $fields) {
			fputcsv($handle, $fields);
		}
	fclose($handle);
}
// Name Field
if (isset($_POST['personName']) && !empty($_POST['personName'])){
    $personName = ucfirst(htmlspecialchars(strip_tags($_POST['personName'])));
       
} else {
	$errorMessage = "Required field empty.  Please complete your entry.";
}
// Address Field
if (isset($_POST['address']) && !empty($_POST['address'])){
    $address = ucfirst(htmlspecialchars(strip_tags($_POST['address'])));
       
} else {
	$errorMessage = "Required field empty.  Please complete your entry.";
}
// City Field
if (isset($_POST['city']) && !empty($_POST['city'])){
    $city = ucfirst(htmlspecialchars(strip_tags($_POST['city'])));
       
} else {
	$errorMessage = "Required field empty.  Please complete your entry.";
}
// State Field
if (isset($_POST['state']) && !empty($_POST['state'])){
    $state = ucfirst(htmlspecialchars(strip_tags($_POST['state'])));
       
} else {
	$errorMessage = "Required field empty.  Please complete your entry.";
}
// Zip Field
if (isset($_POST['zip']) && !empty($_POST['zip'])){
    $zip = ucfirst(htmlspecialchars(strip_tags($_POST['zip'])));
       
} else {
	$errorMessage = "Required field empty.  Please complete your entry.";
}
// Phone Field
if (isset($_POST['phone']) && !empty($_POST['phone'])){
    $phone = ucfirst(htmlspecialchars(strip_tags($_POST['phone'])));
       
} else {
	$errorMessage = "Required field empty.  Please complete your entry.";
}

$addressArray = ['personName' => $personName, 'address' => $address, 'city' => $city, 'state' => $state, 'zip' => $zip, 'phone' => $phone];

// header("Location: address_book.php");
// exit;
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
	<hr/>
	<? if (!empty($errorMessage)):?> <?=$errorMessage; endif; ?>
	<form method="POST" action="">
		<label for='personName'> Name: </label>
	    <input id="personName" name="personName" type="text" autofocus = 'autofocus' tab=1 placeholder="Enter First and Last Name" style="width:200px;">
	    <p></p>
	    <label for='address'> Address: </label>
	    <input id='address' name='address' type="text" tab=2 placeholder="Enter First and Last Name" style="width:200px;">
	    <p></p>
	    <label for='city'> City: </label>
	    <input id="city" name="city" type="text" tab=3 placeholder="Enter First and Last Name" style="width:200px;">
	    <p></p>
	    <label for='state'> State: </label>
	    <input id="state" name="state" type="text" tab=4 placeholder="Enter First and Last Name" style="width:200px;">
	    <p></p>
	    <label for='zip'> Zip: </label>
	    <input id="zip" name="zip" type="text" tab=5 placeholder="Enter First and Last Name" style="width:200px;">
	    <p></p>
	    <label for='phone'> Phone: </label>
	    <input id="phone" name="phone" type="text" tab=6 placeholder="Enter First and Last Name" style="width:200px;">
	    <p></p>
	    <input type="submit" value="Update Address Book" />
	</form>


</body>
</html>