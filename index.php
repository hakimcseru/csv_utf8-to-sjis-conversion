<?php 
/* 
This function i write to read a SJIS input file and output UTF-8 
@input utf-8 csv file
@output shiftjis csv file
@author M A Hakim
*/
function csv_utf8_to_sjis(){
    try {
    	// Read shiftjis csv file 
		$myfile = fopen("utf-8.csv", "r") or die("Unable to open file!");
        // create output csv file to write
        $csvFileName = "tmp/".time() . rand() . '.csv';
        $res = fopen($csvFileName, 'w');

        if ($res === FALSE) {
            throw new Exception('You dont have permission to create/write a file');
        }

        // Loop per line until end-of-file
		while(!feof($myfile)) {
			$dataInfo= fgets($myfile);
        	$dataInfo_out=mb_convert_encoding ($dataInfo , "SJIS" , "ASCII,JIS,UTF-8,EUC-JP,SJIS");
            fwrite($res, $dataInfo_out);
		}

		// Close shiftjis csv file 
		fclose($myfile);

        // Set download file name
        $fname = date('Y-m-d').'-'.'sjis';

        // Close output csv file 
        fclose($res);

        // Send the file to header for download
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename='.$fname.'.csv');
        header('Content-Transfer-Encoding: binary');
        header('Content-Length: ' . filesize($csvFileName));
        readfile($csvFileName);
        
    } catch(Exception $e) {
        // Error message
        echo $e->getMessage();
  		}
    die;
    exit();
}

// Call the function
csv_utf8_to_sjis()
?>