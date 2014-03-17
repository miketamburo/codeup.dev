<?php
// Get new instance of MySQLi object
$mysqli = @new mysqli('127.0.0.1', 'mike', 'password', 'todo_db');

// Check for errors
if ($mysqli->connect_errno) {
    echo 'Failed to connect to MySQL: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error;
} else {
	echo $mysqli->host_info . "\n";
}

// COMMENT OUT THE SECTIONS YOU DO NOT NEED IN ORDER TO CREATE NEW TABLE !!!!!!!!!!!!!!!!!!!
$query = 'CREATE TABLE todo_db (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    thing_to_do VARCHAR(100) NOT NULL,
    completed VARCHAR(100) DEFAULT 0,
    PRIMARY KEY (id)
);';

// THIS SECTION IS COMMON TO ALL ABOVE SECTIONS WHEN CREATING A NEW TABLE (USE WITH ANY SECTION ABOVE)
// Run query, if there are errors then display them

if (!$mysqli->query($query)) {
    throw new Exception("Table creation failed: (" . $mysqli->errno . ") " . $mysqli->error);
}

?>