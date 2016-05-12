<?php
/**
 * Created by PhpStorm.
 * User: Owner
 * Date: 2016/05/09
 * Time: 15:22
 */
require_once "./class/Reserve.php";
require_once "./class/SeatModel.php";
require_once "./class/ReserveModel.php";

$rm = new ReserveModel();
//$res = new Reserve();
//$res->setCourse("4");
//$res->setStartTime("15:30:00");
//$res->setStartDay("2016-05-10");
//$res->setPeopleNum(4);
//$res->setCourse("7");
//$res->setCourse_flag(false);
//$res->setSID(5);
//echo($rm->setReserve($res)."<br>");
echo "<pre>";
var_dump($rm->deleteReserve(21));
echo "</pre>";
echo($rm->getReserve(1))."<br>";
echo($rm->getReserve(2))."<br>";
echo($rm->getReserve(3))."<br>";
echo($rm->getReserve(4))."<br>";
echo($rm->getReserve(5))."<br>";
echo($rm->getReserve(6))."<br>";
echo($rm->getReserve(7))."<br>";
echo($rm->getReserve(8))."<br>";
echo($rm->getReserve(9))."<br>";
echo($rm->getReserve(21))."<br>";
echo($rm->getReserve(11))."<br>";
echo($rm->getReserve(12))."<br>";
echo($rm->getReserve(13))."<br>";
echo($rm->getReserve(14))."<br>";
echo($rm->getReserve(23))."<br>";
echo($rm->getReserve(25))."<br>";
echo($rm->getReserve(27))."<br>";
echo($rm->getReserve(30))."<br>";
?>