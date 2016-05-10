<?php
/**
 * Created by PhpStorm.
 * User: Owner
 * Date: 2016/05/09
 * Time: 15:22
 */
require_once "./Reserve_test.class.php";
require_once "./SeatModel.php";
require_once "./ReserveModel.php";

$rm = new ReserveModel();
$res = new Reserve();
$res->setCourse("4");
$res->setStartTime("16:00:00");
$res->setStartDay("2016-05-10");
$res->setPeopleNum("10");
$res->setCourse("7");
$res->setCourse_flag(false);
$res->setSID(5);
var_dump($rm->setReserve($res));
var_dump($rm->getReserve(1));
var_dump($rm->getReserve(2));
var_dump($rm->getReserve(3));
var_dump($rm->getReserve(4));
var_dump($rm->getReserve(5));
var_dump($rm->getReserve(6));
var_dump($rm->getReserve(7));
var_dump($rm->getReserve(8));
var_dump($rm->getReserve(9));
var_dump($rm->getReserve(21));
var_dump($rm->getReserve(11));
var_dump($rm->getReserve(12));
?>