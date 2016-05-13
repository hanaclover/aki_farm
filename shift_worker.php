<!DOCTYPE html >
<html>

<head>
<meta charset='utf8'>
<meta http-equiv="content-style-type" content="text/css" />
<link rel="stylesheet" type="text/css" href="shift_worker.css" />
<?php
require_once("calendar.php");
require_once("database_class.php");
require_once("schedule.php");
require_once("login_check.php");

//表示するyearとmonthを定める
$year=date("Y");
$month=date("m");
if(isset($_POST["month"])){
	$month=$_POST["month"];
}
if(isset($_POST["year"])){
	$year=$_POST["year"];
}

$method="";
if(isset($_POST["next"])){
	$method="next";
}else if(isset($_POST["prev"])){
	$method="prev";
}else if(isset($_POST["now"])){
	$method="now";
}

//次や前、今月ボタンを押したときの年月計算
$year=turnCalendar($year,$month,$method)[0];
$month=turnCalendar($year,$month,$method)[1];

//年月の日数計算
$day=num_month($year,$month);

//$name,$user_idの初期化
$name="noname";
$user_id="noid";

//ログイン状態のとき$nameと$user_idを取得
if(isset($_SESSION)){
	$name=$_SESSION["NAME"].$_SESSION["FIRSTNAME"];
	$user_id=$_SESSION["ID"];
}else{
}

?>

<script >
<!--
function turn(element){
//element番目のボタンの色を変更

var col=document.b1.elements[element].style.backgroundColor;
if(col=="red"){
	document.b1.elements[element].style.background="blue";
	document.hb.elements[element].value=1;
}else{
	document.b1.elements[element].style.background="red";
	document.hb.elements[element].value=0;
}

}

function inputSchedule(){
	//月のカレンダーを出力
	
	var i=0;
	for(i=0;i< <?php echo $day; ?> ;i++){
	
		if(document.hb.elements[i].value==1){
				document.b1.elements[i].style.background="blue";
				document.hb.elements[i].value=1;
		}else{
				document.b1.elements[i].style.background="red";
				document.hb.elements[i].value=0;
		}

		
	}
	
	
}


// -->
</script>



<meta charset="utf-8">
<title>sumtrue</title>
</head>
<body >
<div><div>
名前:<?php echo $name; ?>
<br>
シフト締切:前月25日
<br>
</div>

<div>
<table border="/">
<tr><?php echo  $year."年".$month. " 月"; ?>
<?php //echo $month; ?>
<form method="post" action="">
<input type="submit" name="prev" value="前の月"  /> 
<input type="submit" name="next" value="次の月"  /> 
<input type="submit" name="now" value="今月"  /> 
<input type="hidden" name="month" value=<?php  echo $month; ?>>
<input type="hidden" name="year" value=<?php  echo $year; ?>>
</form>

<th>日
<th>月
<th>火
<th>水
<th>木
<th>金
<th>土
</tr>

<form method ="post" action="" name="b1" class="squareBt">
<?php
//SQL文で最後に\Gを加えると列ごとに表示

$db=new database();
$table="shift_submit";//テーブル名指定	
	
	//提出された場合
	if(isset($_POST["schedule_worker"])){
			
		//データベースのシフトデータの更新
		$column="shift_data";
		$where=" user_id ="."\"".$user_id."\"". " AND shift_month=". $_POST["month_submit"];
		$col="shift_data";//insertするcolumn指定
		$shift_data=implode("," , $_POST["schedule_worker"]);//insertするvalue指定
		$data="\"".$shift_data."\"";
		$db->update2($table,$col,$data,$where);
		
		//２ヶ月前のデータ更新(シフトをゼロにする)
		$upd=operationCalendar(date("Y"),date("m"),-2);
		$where=" user_id ="."\"".$user_id."\"". " AND shift_month=". $upd[1];
		$zero_arr=array();
		for($i=0;$i<num_month($upd[0],$upd[1]);$i++){
			$zero_arr[]=0;
		}
		$zero_data=implode("," , $zero_arr);//insertするvalue指定
		$data="\"".$zero_data."\"";
		$db->update2($table,$col,$data,$where);
	
	}

	$arr= array();
		
	/**  カレンダー表示 **/		
		echo "<tr>";
		//初月の曜日揃え
		for($j=0;$j<date_id($year,$month,1);$j++){
			echo "<td>"." ";
		}
		
		for($j=1;$j<=7-date_id($year,$month,1);$j++){
			//echo "<td>".($j);
			echo "<td>";
			
				echo '<input type="button" class=“squareBt”  value='.$j.'&nbsp&nbsp'.' onClick=turn('.($j-1).')    >' ;
				
		}
		echo "</tr>";
		
		//週ごとに改行
		$cnt=0;
		for($i=$j;$i<=$day;$i++){
			if(($i-$j)%7==0){
				echo "<tr>";
			}
			echo "<td>";
			if($i<10){
				echo "<input type=\"button\" name=\"sche[]\" value=".$i."&nbsp&nbsp"." onClick=turn(".($i-1).") class=“squareBt” >" ;
			}else{
				 echo "<input type=\"button\" name=\"sche[]\" value=".$i." onClick=turn(".($i-1).") class=“squareBt” >" ;
			}
			if(($i-$j)%7==6){
				echo "</tr>";
			}
		}	
	
?>
</table>
</form>
</div><div>

<form action=""   >
<input id ="input" type="button" value="前回のデータ読み込み" onClick="inputSchedule();">
</form>



<form method="post" action="" name="hb" >
<?php

$db=new database();
$table="shift_submit";//テーブル名指定	

$column="shift_data";
//$where=" user_id ="."\"".$user_id."\"";
$where=" user_id ="."\"".$user_id."\"". " AND shift_month=". $month;
$arr=$db->select($table,$column, $where);
$arr=scheduleToArray($arr);
for($i=0;$i<$day;$i++){
	if(count($arr)>0){
		
		if($arr[$i]==1){
			echo "<input type=\"hidden\" name=\"schedule_worker[]\" value=1>";
		}else{
			echo "<input type=\"hidden\" name=\"schedule_worker[]\" value=0>";
		}
	}else{
		echo "<input type=\"hidden\" name=\"schedule_worker[]\" value=0>";
	}
	
}

	
?>
<input type="hidden" name="month_submit" value=<?php  echo $month; ?>>
<input type="submit" name="submit" value="提出" onClick="alert('シフトを提出しました。');" /> 
</form>
<button  onclick="location.href='logout.php'">ログアウト</button>
<button  onclick="location.href='shift_confirm.php'">シフト確認</button>
<input type="button" class="squareBt" value="test" />

<br>赤:空いてない
<br>青:空いている
</div></div>

</body>
</html>









