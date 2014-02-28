<?php

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

	function __construct($filename = "data/address_book.csv"){
		$this->filename = $filename;
	}
	
}

?>