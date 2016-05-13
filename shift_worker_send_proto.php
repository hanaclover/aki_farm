<?php>
$yearNow = date("Y");
$monthNow = date("m");
$day = num_month($year,$month);


$month = $monthNow;
$year = $yearNow;
if(isset($_POST["month"])){
	$monthPost = $_POST["month"];
	if($monthPost>12){
		$month = $monthPost - 12;
		$year = $yaerNow + 1;
	}else if($monthPost<=0){
		$month = $monthPost + 12;
		$year = $yearNow - 1;
	}
}else{
	$monthPost = $month;
}

$startDay = date_id($year, $month, 1);
?>



<html>
<head><meta charset="utf8"></head>

<body>

<?php 
echo $data["name"];
echo "<br>$yearNow年$month月<br>";
?>



<form method="post" action="">
<?php if($monthPost - $monthNow > 7){	?>
<input type = "button" name="month" value="<?php echo $monthPost+1; ?>">
<?php }else if($monthPost - $monthNow < 0 ){	?>
<input type = "button" name="month" value="<?php echo $monthPost-1; ?>">
<?php }	?>





<form  method="post"  action="" name="test">

<table border=1><tr>
<?php	for($i=1;$i<31;$i++){echo "<td>$i</td>";}	?>
</tr>
<tr>
<?php	for($i=0;$i<30;$i++){
	echo '<td><input type="checkbox" name="schedule[]" value='.$i .' ></td>';
}?>
</tr>
</table>


<input type="submit" name="submit" value="提出">
</form>

	



</body>
</html>
