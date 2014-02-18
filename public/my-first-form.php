<?php
// action changed to "" so return is to file itself
echo "<p>GET:</p>";
var_dump($_GET);

echo "<p>POST:</p>";
var_dump($_POST);


?>

<!DOCTYPE html>
<html>

<head>
	<title> My First Form </title>
</head>
	<h3> User Login </h3>
	<form method="POST" action="">
	    <p>
	        <label for="username">Username</label>
	        <input id="username" name="username" placeholder="username" type="text">
	    </p>
	    <p>
	        <label for="password">Password</label>
	        <input id="password" name="password" placeholder="password" type="password">
	    </p>
	    <p>
	        <button type="submit">login</button>
	    </p>
	</form>

	<h3> Compose an Email </h3>

	<form method="POST" action="http://requestb.in/13xpwdz1">
	    <p>
	        <label for="To">To:</label>
	        <textarea id="To" name="To" rows="1" cols="30"></textarea>
	    </p>
	    <p>
	        <label for="From">From:</label>
	        <textarea id="From" name="From" rows="1" cols="30"></textarea>
	    </p>
	     <p>
	        <label for="subject">Subject:</label>
	        <textarea id="subject" name="subject" rows="1" cols="30"></textarea>
	    </p>
	     <p>
	        <label for="message">Message</label>
	        <textarea id="message" name="message" rows="10" cols="40"> Compose Your Email </textarea>
	    </p>
	    <p>
	    	<label for = "save_copy">
	    		<input type="checkbox" id="save_copy" name="save_copy" value="yes" checked> Save a copy to sent folder
	    	</label>
	    </p>
	    <p>
	        <input type="submit" value="send" />
	    </p>
	</form>

<h3> Multiple Choice Test </h3>

	<form method="POST" action="http://requestb.in/13xpwdz1">
	    <p>
	       What is the best city in Texas? 
	    </p>
	    <p>
	       <label for = "q1a">
	    		<input type="radio" id="q1a" name="q1[]" value="Dallas"> Dallas 
	    	</label>
	    	<label for = "q1b">
	    		<input type="radio" id="q1b" name="q1[]" value="San Antonio"> San Antonio 
	    	</label>
	    	<label for = "q1c">
	    		<input type="radio" id="q1c" name="q1[]" value="Austin"> Austin 
	    	</label>
	    	<label for = "q1d">
	    		<input type="radio" id="q1d" name="q1[]" value="Wichita Falls"> Wichita Falls 
	    	</label>
	    </p>
	    <p>
	       Where is the best food found in Texas? 
	    </p>
	    <p>
	       <label for = "q2a">
	    		<input type="radio" id="q2a" name="q2[]" value="Dallas"> Dallas 
	    	</label>
	    	<label for = "q2b">
	    		<input type="radio" id="q2b" name="q2[]" value="San Antonio"> San Antonio 
	    	</label>
	    	<label for = "q2c">
	    		<input type="radio" id="q2c" name="q2[]" value="Austin"> Austin 
	    	</label>
	    	<label for = "q2d">
	    		<input type="radio" id="q2d" name="q2[]" value="Waco"> Waco 
	    	</label>
	    </p>
	    <p>
	       What Texas cities have you visited? 
	    </p>
	    <p>
	       <label for = "q3a">
	    		<input type="checkbox" id="q3a" name="q3a" value="Dallas"> Dallas 
	    	</label>
	    	<label for = "q3b">
	    		<input type="checkbox" id="q3b" name="q3b" value="San Antonio"> San Antonio 
	    	</label>
	    	<label for = "q3c">
	    		<input type="checkbox" id="q3c" name="q3c" value="Austin"> Austin 
	    	</label>
	    	<label for = "q3d">
	    		<input type="checkbox" id="q3d" name="q3d" value="Wichita Falls"> Wichita Falls 
	    	</label>
	    </p>
	    <p>
	        <input type="submit" value="send" />
	    </p>
	</form>

</html>