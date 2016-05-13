<?php

$link = mysqli_connect('localhost','user', 'password','Akifarm_db');
$query = 'select u.id, u.name, s.shift_data from user_ploto u join shift_submit_proto s on u.id = s.id'; 
$res = mysqli_query($link, $query);


?>


<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
</head>
<body>




<<<<<<< HEAD
<table border=1>
<tr><td>name</td>
<?php for($i=1; $i<31; $i++){	echo "<td>$i</td>";}	?>
=======
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
		$sol2=$problem->solve_step2($sol1);
	
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
		
		$db=new database();
		$table=	"shift_fix_proto";//テーブル名指定
		$where=" shift_year= ".$arr[0]["shift_year"]." AND shift_month= ".$arr[0]["shift_month"];
		$db->delete($table,$where);
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
		header("Location:./shift_confirm_proto.php");
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
>>>>>>> 72058642ee4dd7b00120a850c19bf9c989401c77
</tr>




<?php	
while($row = mysqli_fetch_assoc($res)){	?>
	<tr><td>
	<?php	echo $row["name"];	?>
	</td>
	<?php
	$data = explode(',', $row["shift_data"]);
	foreach($data as $val){	?>
		<td>
		<?php	echo	$val==0 ? '×' : '◯';	?>
		</td>
	<?php	}	?>
	</tr>
<?php	}	
mysqli_close($link);
?>


</table>

</body>
</html>
