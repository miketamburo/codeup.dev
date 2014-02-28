<?php

class Filestore {
	public $filename = '';
	public $items = [];
	public $contents = [];

	public function __construct($filename = ''){
		$this->filename = $filename;
	}

	// returns array of lines in $this->filename
	public function read_lines(){
		$handle = fopen($this->filename, "r");
		$fileSize1 = filesize($this->filename);
		if ($fileSize1 > 0){
			$contents = fread($handle, $fileSize1);
		} else {
			$contents = [];
		}	
		fclose($handle);

		if (is_string($contents)){
			$contents = explode("\n", $contents);	
		} 	
		
		return $contents;
	}
	// writes each element in $array to a new line in $this-> filename
	public function write_lines($items){
		$handle = fopen($this->filename, "w");
        $item = implode("\n", $items);
        fwrite($handle, $item);
        fclose($handle);
        return $items;
    }

	// Reads contents of csv $this->filename, returns an array
	public function read_csv(){
		$contents = [];
		$handle = fopen($this->filename, 'r');
		while(($data = fgetcsv($handle)) !== FALSE) {
	  		$contents[] = $data;
		}
		fclose($handle);
		return $contents;
	}

	public function write_csv($contents){
		$handle = fopen($this->filename, 'w');
			foreach ($contents as $fields) {
				fputcsv($handle, $fields);
			}
		fclose($handle);
	}
}