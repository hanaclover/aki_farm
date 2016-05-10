<?php
/**
 * Created by PhpStorm.
 * User: Owner
 * Date: 2016/05/09
 * Time: 15:22
 */
require_once "./Reserve.php";
require_once "./SeatModel.php";
require_once "./ReserveModel.php";

$rm = new ReserveModel();
$res = new Reserve();
$res->setCourse("4");
$res->setStartTime("15:30:00");
$res->setStartDay("2016-05-10");
$res->setPeopleNum(4);
$res->setCourse("7");
$res->setCourse_flag(false);
$res->setSID(5);
echo($rm->setReserve($res)."<br>");
echo($rm->getReserve(1));
echo($rm->getReserve(2));
echo($rm->getReserve(3));
echo($rm->getReserve(4));
echo($rm->getReserve(5));
echo($rm->getReserve(6));
echo($rm->getReserve(7));
echo($rm->getReserve(8));
echo($rm->getReserve(9));
echo($rm->getReserve(21));
echo($rm->getReserve(11));
echo($rm->getReserve(12));
?>