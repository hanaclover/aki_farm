<?php
/**
 * Created by Hana.
 * Date: 2016/05/17
 */
require_once "class/PDODatabase.class.php";
require_once "class/ReserveModel.php";
require_once "class/Reserve.php";
require_once "class/SeatModel.php";

$sid = $_GET["sid"];
$rm = new ReserveModel();
$res = new Reserve();

$rid = $rm->returnRIDNow( $sid );
$rm->deleteReserve( $rid );
echo "予約をキャンセルしました";
//
//if ($rm->getReserve($sm->getSeatNumfromSID($sid))["flag"] == 0) {
//    $rm->setReserve($res);
//    echo "入店を受け付けました";
//}else{
//    echo "席が予約されておりますので、\n予約できません";
//}
?>           

