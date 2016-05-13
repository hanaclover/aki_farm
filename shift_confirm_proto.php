<!DOCTYPE html >
<html>

<head>
<?php
require_once("database_class.php");
require_once("calendar.php");
//require_once("login_check.php");
//$id="sumtrue";
 
$year=date("Y");
$month=date("m");
$day=num_month($year,$month);
$shop=array("A","B","C");

$db=new database();
$table="shift_fix_proto";
$column="";//アスタリスクになる
$where=" delete_flg =0";
$arr=$db->select($table,$column, $where);
$person=count($arr);
//$day=31;	//日数（仮）
$shift=explode(',',$arr[0]["shift_data"]);
$day=count($shift);
?>
<?php 
/*
function compare_row($matrix , $str, $j){
	//matrixのj番目の列でstrと書かれているものを返す
	$result="";
	for($i=0;$i<count($matrix);$i++){
		if($matrix[$i][$j]==$str){
			$result=$result."<br>".$str;
		}
	}
	return $result;
}
*/
?>



</head>

<body>

<br>
<br>
<?php echo $arr[0]["shift_year"]."年  ".$arr[0]["shift_month"]."月"   ?>
<table border="/">
<th>名前


<?php
 
	for ($j=0;$j<$day;$j++ ){
		//dayの出力
		echo "<th>".($j+1);
	}
	for($i=0;$i<$person;$i++){
		//人の出力
		echo "<tr>";
		echo "<td>".$arr[$i]["name"];
		$shift=explode(',',$arr[$i]["shift_data"]);
		for($j=0;$j<$day;$j++){
			//表データボタン作成
			
			
			
			echo "<td>";
			if(isWork($shift[$j],$shop)){
				echo "$shift[$j] <br>";
			}else{
				echo "<br>";
			}
		}
	echo"</tr>";
	}	
	
	/*
	for ($j=0;$j<$day;$j++ ){
		//dayの出力
		echo "<th>".($j+1);
	}
	$shift=array();
	for($i=0;$i<$person;$i++){	
			$shift[]=explode(',',$arr[$i]["shift_data"]);	
	}
	var_dump($shift);
	for($s=0;$s<count($shop);$s++){
		echo "<tr>";
		echo "<td>".$shop[$s];
		
		for($j=0;$j<$day;$j++){
			//表データボタン作成
			echo "<td>";
			//echo "compare_row($shift,$shop[$s],$j)"; 
			
			echo "<br>";
		}
	echo"</tr>";
		
	}
	*/

?>
</table>
<?php 

function isWork($str,$shop){
	$result=false;
	for($s=0;$s<count($shop);$s++){
		if($str==$shop[$s]){
			$result=true;
		}
	}
	return $result;
	
}
?>

</body>


</html>