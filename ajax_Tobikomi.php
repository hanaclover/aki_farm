<?php
/**
 * Created by PhpStorm.
 * User: Owner
 * Date: 2016/05/13
 * Time: 17:26
 */
require_once "./class/ReserveModel.php";
require_once "./class/Reserve.php";

$sid = $_GET["sid"];
$rm = new ReserveModel();
$res = new Reserve();
//confirmReserveを追加してください
$res->setSID($sid);
$res->setStartDay(date("Y-m-d"));
//$res->setStartTime(date("H:i:s",strtotime(date("H:i:s"))+3600*7));
$res->setStartTime(date("H:i:s",strtotime(date("H:i:s"))));
$rm->setReserve($res);
