<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">

<?php 
require_once("shiibashi.php");
require_once("database_class.php");
require_once("calendar.php");
require_once("login_check.php");


///表示するyearとmonthを定める
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

//年月計算
$year=turnCalendar($year,$month,$method)[0];
$month=turnCalendar($year,$month,$method)[1];

$db=new database();
$table="shift_submit";//テーブル名指定	

//月に提出されたデータをすべて取り出す
$where=" shift_month=". $month;
$column="";
$arr=$db->select($table,$column, $where);

//人数の長さ
$person=count($arr);

//文字列の分解
$shift=explode(',',$arr[0]["shift_data"]);

//月の日数
$day=num_month($year,$month);

//店舗情報
$shop=array("A","B","C");


?>

<!-- 以下のjavascript関数は別ファイルに記述するのが望ましい -->
<title>sumtrue manager</title>
<script>
function turn(element){
	var val=document.b2.elements[element].value;
	if(val=="A"){
		document.b2.elements[element].value="B";
		document.b3.elements[element].value="B";
		setColor(element);
	}else if(val=="B"){
		document.b2.elements[element].value="C";
		document.b3.elements[element].value="C";
		setColor(element);
	}else if(val=="C"){
		document.b2.elements[element].value="o";
		document.b3.elements[element].value=1;
		setColor(element);		
	}else if(val=="o"){
		document.b2.elements[element].value="x";
		document.b3.elements[element].value=0;
		setColor(element);
	}else if(val=="x"){
		document.b2.elements[element].value="A";
		document.b3.elements[element].value="A";
		setColor(element);
	}
}


function sum_row(shop,j){
	var ans=0;
	var itr=0;
	for(itr=0;itr< <?php echo $person;?> ; itr++){
		var val=document.b2.elements[j+itr*<?php echo $day; ?>].value;	
		if(val==shop){
			ans++;
		}
	}
	return ans;
}



function setColor(i){
	var val=document.b2.elements[i].value;
	if(val=="A"){
		document.b2.elements[i].style.background="yellow";
		document.b3.elements[i].value="A";	
	}else if(val=="B"){
		document.b2.elements[i].style.background="blue";
		document.b3.elements[i].value="B";
	}else if(val=="C"){
		document.b2.elements[i].style.background="rgb(0,250,0)";
		document.b3.elements[i].value="C";
	}else if(val=="o"){
		document.b2.elements[i].style.background="white";
		document.b2.elements[i].value="o";
		document.b3.elements[i].value=1;
	}else {
		document.b2.elements[i].style.background="red";
		document.b2.elements[i].value="x";
		document.b3.elements[i].value=0;	
	}
	
	//document.form_shop.elements[i-i/30].value=sum_row("A",i-i/30);
	document.form_shop.elements[i-Math.floor((i/<?php echo $day; ?>))*<?php echo $day; ?>].value=sum_row("A",i-Math.floor((i/<?php echo $day; ?>))*<?php echo $day; ?>);
	document.form_shop.elements[<?php echo $day; ?>+i-Math.floor((i/<?php echo $day; ?>))*<?php echo $day; ?>].value=sum_row("B",i-Math.floor((i/<?php echo $day; ?>))*<?php echo $day; ?>);
	document.form_shop.elements[<?php echo 2*$day; ?>+i-Math.floor((i/<?php echo $day; ?>))*<?php echo $day; ?>].value=sum_row("C",i-Math.floor((i/<?php echo $day; ?>))*<?php echo $day; ?>);
	
	
}

</script>

</head>
<body>
<?php echo $year."年 ".$month."月 ";  ?>
<br>
<form method="post" action="">
<input type="submit" name="prev" value="前の月"  /> 
<input type="submit" name="next" value="次の月"  /> 
<input type="submit" name="now" value="今月"  /> 
<input type="hidden" name="month" value=<?php  echo $month; ?>>
<input type="hidden" name="year" value=<?php  echo $year; ?>>
</form>



<table border="/">
<tr>schedule
<th>名前



<form  action="" name="b2">
<?php 
//****スケジュール作成****************************/////////////

	$sup=array();//sup[i][j] i in person set, j in day set  人iがj日に供給できるとき1もしくは店舗名、そうでなければ0
	$dem=array();//dem[j] j in day set j日の需要量
	$year=array();//year[i] i in person set 人iの勤続年数
	
if(isset($_POST["schedule"])){//makeボタンを押されたらtrue
	$sol2=array();
	if(isset($_POST["submit"])){
		for($j=0;$j<$day;$j++){
			for($i=0;$i<$person;$i++){
				//スケジュール表のデータをsupに代入
				$sup[$i][$j]=$_POST["schedule"][$i*$day+$j];
				if($sup[$i][$j]>1){
					$sup[$i][$j]=1;
				}
			}
			if($j%7==3||$j%7==4){
				//テスト的に金土を設定　*count($shop)に変えたほうがいい
				$dem[$j]=4*3;
			}else{
				//上記以外
				$dem[$j]=2*3;
			}		
		}
	
	//DBから勤続年数を計算する仕様にできていない。
		for($i=0;$i<$person;$i++){
			//人iの勤続年数を入力
			$year[$i]=$i+1;
		}

		//shiibashiクラスの作成
		/* クラスの各メンバーを代入して、solve_step1とsolve_step2で解を得る
		*/
		$problem=new shiibashi();
		$problem->setSupply($sup);
		$problem->setDemand($dem);
		$problem->setShop($shop);
		$problem->setYear($year);
		$sol1=$problem->solve_step1();
		$sol2=$problem->solve_step2($sol1);//最終的に出力される解
	
//******************************************//

//******************以下は出力**********//
	
		for ($j=0;$j<$day;$j++ ){
			//dayの出力
			echo "<th>".($j+1);
		}
	
		echo "<script> var index=0;</script>";
		for($i=0;$i<$person;$i++){
			//人の出力
			echo "<tr>";
			echo "<td>".$arr[$i]["name"];	
			$shift=explode(',',$arr[$i]["shift_data"]);
			$day=count($shift);
		
			for($j=0;$j<$day;$j++){
				//解の出力
				echo "<td>";
				echo "<input type=\"button\"  value=".$sol2[$i][$j]. " onClick=turn(".($j+$i*$day).")>";
			
				//色の表示
				echo "<script>setColor(index)</script>";
				echo "<script> index++;</script>";
			}
			echo"</tr>";
		}
	
	} 
	if(isset($_POST["sendToDB"])){
		//シフト決定ボタンが押されたとき
		$sche=array();
		for($i=0;$i<$person;$i++){
			for($j=0;$j<$day;$j++){
				//スケジュール表のデータをsupに代入
				$sche[$i][$j]=$_POST["schedule"][$i*$day+$j];
			}
		}
		
		//すでに
		$db=new database();
		$table=	"shift_fix";//テーブル名指定
		$column="COUNT(*) ";
		$where=" shift_year= ".$arr[0]["shift_year"]." AND shift_month= ".$arr[0]["shift_month"];
		
		$result=$db->select($table,$where);
		if($result[0]["COUNT(*)"]==0){
		
			$col="name,user_id,shift_year,shift_month,shift_data,delete_flg";//insertするcolumn指定
			for($i=0;$i<$person;$i++){
				$shift_data=implode("," , $sche[$i]);//insertするvalue指定
				$data="\"".$arr[$i]["name"]."\""
						.","
						."\"".$arr[$i]["user_id"]."\""
						.","
						.$arr[$i]["shift_year"]
						.","
						.$arr[$i]["shift_month"]
						.","
						."\"".$shift_data."\""
						.","."0"
						;
					
				$db->insert($table,$col,$data);
			}
		
		}else{
				
			for($i=0;$i<$person;$i++){
				$column="shift_data";
				$where=" user_id ="."\"".$arr[$i]["user_id"]."\"". " AND shift_month=". $arr[$i]["shift_month"];
				
				$shift_data=implode("," , $sche[$i]);//insertするvalue指定
				$data="\"".$shift_data."\"";
					
				$db->update2($table,$col,$data,$where);
			}
			
		}
		header("Location:./shift_confirm.php");
		exit();	
	}
}else{
	//makeボタンが押される前に実行される

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
			if($shift[$j]==1){
				echo "<input type=\"button\"  value="."\"○\"". " onClick=turn(".($j+$i*$day).")>";
			}else{
				echo "<input type=\"button\"  value="."\"x\"". " onClick=turn(".($j+$i*$day).")>";
			}
		}
	echo"</tr>";
	}	
	
	
}
?>
</form>

<tr>
<td>　</td>
</tr>

<tr>
<td>店舗</td>
</tr>

<form   name="form_shop">
<?php
for($s=0;$s<count($shop);$s++){
		//人の出力
		echo "<tr>";
		echo "<td>".$shop[$s];
		for($j=0;$j<$day;$j++){
			//表データボタン作成
				
			echo "<td>";
	
			
			if(isset($_POST["submit"])&&isset($_POST["schedule"])){	
				echo "<input type=\"button\"   value=". shop_supply($shop[$s],$j,$sol2,$person) .">";
			}else{
				echo "<input type=\"button\"  value=0>";	
			}
		}
	echo"</tr>";
}

function shop_supply($shop,$j,$arr,$person){
	$ans=0;
	for($itr=0;$itr< $person;  $itr++){
		$val=$arr[$itr][$j];	
		if($val===$shop){
			$ans++;
		}
	}
	return $ans;
}	
?>
</table>
</form>

<!-- postする値をhiddenタグで作成  -->
<form method="post" action="" name="b3">
<?php


	//***hiddenタグでスケジュールの値を保存******////
	echo "<script> var index=0;</script>";
	for($i=0;$i<$person;$i++){
		$shift=explode(',',$arr[$i]["shift_data"]);
		for($j=0;$j<$day;$j++){
			if(isset($_POST["submit"])&&isset($_POST["schedule"])){	
				if($sol2[$i][$j]==="A"){
					echo "<input type=\"hidden\"  value=A name=\"schedule[]\" )>";
				}else if($sol2[$i][$j]==="B"){
					echo "<input type=\"hidden\"  value=B  name=\"schedule[]\" )>";
				}else if($sol2[$i][$j]==="C"){
					echo "<input type=\"hidden\"  value=C  name=\"schedule[]\" )>";
				}else{
					echo "<input type=\"hidden\"  value=0  name=\"schedule[]\" )>";
				}
			}else{
				if($shift[$j]==1){
					echo "<input type=\"hidden\"  value=1 name=\"schedule[]\" )>";
				}else{
					echo "<input type=\"hidden\"  value=0  name=\"schedule[]\" )>";
				}
			}
		echo "<script>index++;</script>";
		}
	}
?>
<input type="submit" name="submit" value="シフト作成">
<input type="submit" name="sendToDB" value="シフト決定">
</form>

<!--  未完成  -->
<form  action="" name="b4">
<table border="/">
<tr>各店舗
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
			if($shift[$j]==1){
				echo "<input type=\"button\"  value="."\"○\">";
			}else{
				echo "<input type=\"button\"  value="."\"x\">";
			}
		}
	echo"</tr>";
	}	
	
?>
</table>
</form>

</body>
</html>


