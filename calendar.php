<?php

function num_month($year,$month){

$ans=0;
switch($month){
 case 4;
 case 6;
 case 9;
 case 11;
	$ans=30;
	break;
 case 1;
 case 3;
 case 5;
 case 7;
 case 8;
 case 10;
 case 12;	
	$ans=31;
	break;
 case 2;
	if($year%4!=0){
		$ans=28;
		break;
	}else if($year%4==0&&$year%400==0){
		$ans=28;
		break;
	}else{
		$ans=29;
		break;
	}
}
return $ans;

}

function date_id($year,$month,$day){

$date_num=date("w",mktime(0,0,0,$month,$day,$year));
$youbi="";
switch($date_num){

case 0;
	$youbi="日";
	break;
case 1;
        $youbi="月";
        break;
case 2;
        $youbi="火";
        break;
case 3;
        $youbi="水";
        break;
case 4;
        $youbi="木";
        break;
case 5;
        $youbi="金";
        break;
case 6;
        $youbi="土";
        break;
}
//return $youbi;
return $date_num;


}


function turnCalendar($year,$month,$method){
	//$year,$monthから$methodに対して1動かす、もしくは動かさないときの年月を配列で返す
	$arr=array();
	if($method==="next"){
		$arr[1]=$month+1;
		$arr[0]=$year+floor($month/12);
		if($arr[1]==13){
			$arr[1]=1;
		}
	}else if($method==="prev"){
		$arr[1]=$month-1;
		if($month==1){
			$arr[0]=$year-1;
			$arr[1]=12;
		}else{
			$arr[0]=$year;
		}
	}else if($method==="now"){
		$arr[0]=date("Y");
		$arr[1]=date("m");
	}else{
		$arr[0]=$year;
		$arr[1]=$month;
	}
	
	$distance=(date("Y")-$year)*(12-date("m"))+($month-date("m"));
	if($distance<-2){
		$arr[0]=date("Y");
	}else if($distance>8){
		$arr[0]=date("Y");
	}
	

	
	return $arr; 
	
}

function operationCalendar($year,$month,$delta){
	//$year,$monthから変化$deltaしたときの年月を返す。
	$result=array();
	$abs_delta=abs($delta);
	$signal=0;
	if($delta>0){
		$signal="next";
	}else{
		$signal="prev";
	}
	for($i=0;$i<$abs_delta;$i++){
		$result=turnCalendar($year,$month,$signal);
	}
	return $result;
	
}




?>
