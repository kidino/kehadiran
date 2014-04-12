<?php

function __autoload($class_name) {
    include 'libs/'.$class_name . '.php';
}


function build_table($senarai) {
	$table_data = "<table border='1'>\r\n";

	$pembilang = 0;
	foreach($senarai as $item) {
		if($pembilang == 0) {
			$table_data .= "<tr><th>bil</th>";
			foreach(array_keys($item) as $table_key) {
				$table_data .= "<th>$table_key</th>";
			}
			$table_data .= "</tr>\r\n";
		}

		$pembilang++;
		$table_data .= "<tr>";
		$table_data .= "<td>$pembilang</td>";
		foreach ($item as $nilai) {
			$table_data .= "<td>$nilai</td>";
		}
		$table_data .= "</tr>\r\n";
	}
	$table_data .= "</table>\r\n";
	return $table_data;
}

function dumper($v){
echo '<pre>';
var_dump($v);
echo '</pre>';
}

function validateMysqlDate( $date ){ 
    if (preg_match("/^(\d{4})-(\d{2})-(\d{2}) ([01][0-9]|2[0-3]):([0-5][0-9]):([0-5][0-9])$/", $date, $matches)) { 
        if (checkdate($matches[2], $matches[3], $matches[1])) { 
            return true; 
        } 
    } 
    return false; 
} 

