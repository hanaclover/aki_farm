<html>
<head>
<meta charset="UTF-8">
</head>
</html>
<?php
/*
 *
 * SeatModel.php
 * made by Hana,20160509
 *
*/
// テスト用
include_once("./class/BaseModel.php");
include_once("./class/PDODatabase.class.php");
include_once("./class/init.php");
include_once("./class/SeatModel.php");
$db = new PDODatabase();
$seat = new SeatModel($db);
$test = $seat->getSeat(32);
echo "<pre>";
var_dump($test);
echo "</pre>";
//

// echo $seat->getJointTableStartNum();
// var_dump($seat->getJointTableSID());

//for($i=2;$i<=3;$i++) {
//    $temps[]=$seat->conbination($i);
//}
//echo "<pre>";
//var_dump($temps);
//echo "</pre>";
//print "<ul>";
//foreach($temps as $tmp){
//    foreach($tmp as $temp) {
//    print "<li>".implode($temp)."</li>";
//}}
//print "</ul>";

