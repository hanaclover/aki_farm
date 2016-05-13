<?php

require_once('database_class.php');
require_once('calendar.php');

$db = new database();

function make_shift($year, $month){

//make default shift_data

$days = num_month($year,$month);

$datas = array();
   for($i=0;$i<$days;$i++)
       $datas[$i]=0;

$data = implode(",", $datas);

return $data;

}

//echo  $opi = make_shift(2016,1);
 

?>
