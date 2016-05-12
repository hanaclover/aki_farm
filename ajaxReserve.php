<?php
/**
 * Created by PhpStorm.
 * User: SooJu
 * Date: 2016-05-10
 * Time: 오후 12:06
 */
include_once("class/Reserve.php");
require_once "class/ReserveModel.php";
    // エラーがないとき、確認ページに移動する

    // 座席チェック
    $msg="";
    $rModel = new ReserveModel();
    $reserve = new Reserve();
    $reserve->setPeopleNum($_GET['peopleNum']);
    $reserve->setStartDay($_GET['StartDay']);
    $reserve->setStartTime($_GET['startTime']);
    $reserve->setSID((string)($rModel->confirmReserve($reserve)));
    if (($reserve->getSID()) == 0){

        echo "予約が埋まっております。大変申し訳ございません。<br>よろしければ".
            "姉妹店をご利用いただけますと幸いです。";

    }
?>