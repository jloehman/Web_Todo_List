<?php

// require ('classes/address_data_store.php');

class Filestore {

    public $filename = '';
    public $is_csv = '';

    public function __construct($filename = '') 
    {
         $this->filename = $filename;
         $this->is_csv = $this->check_file();

    }

    /**
     * Returns array of lines in $this->filename
     */
    public function check_file(){
        $is_csv = substr($this->filename, -3);

        if($is_csv === "csv") {
            return true;
        }else{
            return false;
        }
    }

    public function read(){
        if ($this->is_csv){
            return $this->read_csv();
        }else{
            return $this->read_lines();
        }
    }

    public function write($array){
        if ($this->is_csv) {
            $this->write_csv($array);
        }else{
            $this->write_lines($array);
        }
    }

    private function read_lines() {

        $contents = [];
        if (is_readable($this->filename) && filesize($this->filename) > 0) {
            $handle = fopen($this->filename, 'r');
            $bytes = filesize($this->filename);
            $contents = trim(fread($handle, $bytes));
            fclose($handle);
            $contents = explode("\n", $contents);

        }
        return $contents;
    } 

    /**
     * Writes each element in $array to a new line in $this->filename
     */
    private function write_lines($array) {
        if (is_writable($this->filename)) {
            $handle = fopen($this->filename, 'w');
            $list_string = implode("\n", $array);
            fwrite($handle, $list_string);
            fclose($handle); 
        }   
    }
    
    /**
     * Reads contents of csv $this->this->$array, returns an array
     */
    private function read_csv()
    {
        $address_book = [];
        $handle = fopen($this->filename, 'r');

        while (!feof($handle)){
            $row = fgetcsv($handle);
            if(is_array($row)) {
                $address_book[] = $row;
            }
        }

        fclose($handle);
        return $address_book;
    }

    /**
     * Writes contents of $array to csv $this->filename
     */
    private function write_csv($array)
    {
        $handle = fopen($this->filename, 'w');
        foreach ($array as $fields) {
            fputcsv($handle, $fields);
        }
            fclose($handle);
    }
    
}

?>