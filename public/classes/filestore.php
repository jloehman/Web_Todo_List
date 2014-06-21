<?php



class Filestore {

    public $filename = '';

    function __construct($filename) 
    {
         $this->filename = $filename;

    }
    /**
     * Returns array of lines in $this->filename
     */
    function read_lines() {
        $contents = [];
        if (is_readable($this->filename) && filesize($this->filename) > 0){
            $handle = fopen($this->filename, 'r');
            $bytes = filesize($this->filename);
            $contents = trim(fread($handle, $bytes));
            fclose($handle);
            $contents = explode("\n", $contents);

        }
        return $contents;
    } 
    
    function write_lines($array) {
        // if (is_writable($this->filename)) {
        //     $handle = fopen($this->filename, 'w');
        //     $list_string = implode("\n", $array);
        //     //foreach($array as $items) {
        //         fwrite($handle, $list_string);
        //     //}
        //     fclose($handle); 
        // }   
        $saved_file = fopen($this->filename, 'w');
        $list_string = implode("\n", $array);
        fwrite($saved_file, $list_string);
        fclose($saved_file);
    }
    /**
     * Reads contents of csv $this->this->$array, returns an array
     */
    function read_csv()
    {
        $handle = fopen($this->$array, 'r');
        $address_book = [];

        while (!feof($handle)){
            $row = fgetcsv($handle);
            if(is_array($row)) {
                $address_book[] = $row;
            }
        }

        fclose($handle);
        return $items;
        }

    /**
     * Writes contents of $array to csv $this->filename
     */
    function write_csv($array)
    {
        $handle = fopen($this->$array, 'w');
        foreach ($address_book as $fields) {
            fputcsv($handle, $fields);
        }
            fclose($handle);
    }
}
