<?php

require_once("database_class.php");

function scheduleToArray($schedule_str){
//提出されたシフトを取り出して最後に提出したシフトを出力
$arr=array();

for($i=0;$i<count($schedule_str);$i++){
	$arr=explode(',',$schedule_str[$i]["shift_data"]);
}

return $arr;

}


?>