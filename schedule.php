<?php

require_once("database_class.php");

function scheduleToArray($schedule_str){
//��o���ꂽ�V�t�g�����o���čŌ�ɒ�o�����V�t�g���o��
$arr=array();

for($i=0;$i<count($schedule_str);$i++){
	$arr=explode(',',$schedule_str[$i]["shift_data"]);
}

return $arr;

}


?>