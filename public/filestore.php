<?php

class Filestore {
	public $filename = '';
	public $items = [];
	public $contents = [];
	private $is_csv = FALSE;

	public function __construct($filename = ''){
		$this->filename = $filename;
		if (substr($filename, -3) == 'csv'){
			$this->is_csv = TRUE;
		} elseif (substr($filename, -3) == 'txt'){
			$this->is_csv = FALSE;
		} // consider later addition to address what happens if other file types
		// are introduced e.g. .jpg file.
	}

	public function read(){
		if ($this->is_csv == TRUE) {
			return $this->read_csv();
		} elseif ($this->is_csv == FALSE){
			return $this->read_lines();
		}
	}

	public function write($array){
		if ($this->is_csv == TRUE) {
			return $this->write_csv($array);
		} elseif ($this->is_csv == FALSE){
			return $this->write_lines($array);
		}
	}

	// returns array of lines in $this->filename
	private function read_lines(){
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
	private function write_lines($items){
		$handle = fopen($this->filename, "w");
        $item = implode("\n", $items);
        fwrite($handle, $item);
        fclose($handle);
        return $items;
    }

	// Reads contents of csv $this->filename, returns an array
	private function read_csv(){
		$contents = [];
		$handle = fopen($this->filename, 'r');
		while(($data = fgetcsv($handle)) !== FALSE) {
	  		$contents[] = $data;
		}
		fclose($handle);
		return $contents;
	}

	private function write_csv($contents){
		$handle = fopen($this->filename, 'w');
			foreach ($contents as $fields) {
				fputcsv($handle, $fields);
			}
		fclose($handle);
	}
}