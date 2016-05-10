<?php
/**
 * Created by PhpStorm.
 * User: SooJu
 * Date: 2016-05-10
 * Time: 오후 12:06
 */

/*
 * 1. 4品の場合 AMPのページに渡す
 * 2. 4品以外の場合　→　ContentsCheck()
 * 3. ContentsCheck() RETURN False　→　RESERVEDに戻る
 * 4.
 * 5.
 * 6.
 * 7.
 *
 * */
?>

<?php
include_once("class/Reserve.php");

if( (isset($_POST['course']) == true ? $_POST['course'] : "") == 4 ) {
    // $_POST['course']が4品の場合、AMPのページに渡す リンク修正!!!!
    //echo "<script> window.location.href = 'http://localhost/aki_farm/aki_farm/  '; </script>";
} else {
    //7品、10品の場合、ContentsCheck()
    $reserve->setUID($_POST['UID']);
    // $reserve->setRID($_POST['RID']);     일단 없는 상태로 진행
    // $reserve->setSID($_POST['SID']);     일단 없는 상태로 진행

    $reserve->setPeopleNum($_POST['peopleNum']);
    $reserve->setReservedTime($_POST['ReservedTime']);
    $reserve->setStartDay($_POST['Date']);

    //StartTimeをTime型化
    $startTime = $_POST['hour'].":".$_POST['minute'];
    $reserve->setStartTime($_POST['startTime']);

    //コース
    $reserve->setCourse($_POST['course']);

    if($reserve->getCourse() == 4) {
        $reserve->setCourse_flag(true);

        // Array処理が必要です。AMPとの調整が必要
        $dishName = array($_POST['dishName'][0],$_POST['dishName'][1],$_POST['dishName'][2],$_POST['dishName'][3]);
        $reserve->setCourse_4($dishName);
    }
}

/*function checkInputData($uid, $peopleNum, $reservedTime, $date, $hour, $minute, $startTime) {
    $reserve = new Reserve();

    //$reserve->setUID($_SESSION[]);
    $reserve->setPeopleNum();
    $reserve->setReservedTime();
    $reserve->setStartDay();
    $reserve->setStartTime();



    $reserve->setCourse_flag(false);
    $reserve->setCourse();

    //予約が確定され、SIDとRIDが付与されてるとき

    // <----
    $reserve->setUID($_POST['UID']);
    // $reserve->setRID($_POST['RID']);     일단 없는 상태로 진행
    // $reserve->setSID($_POST['SID']);     일단 없는 상태로 진행
    // ---->

    $reserve->setPeopleNum($_POST['peopleNum']);
    $reserve->setReservedTime($_POST['ReservedTime']);
    $reserve->setStartDay($_POST['Date']);

    //StartTimeをTime型化
    $startTime = $_POST['hour'].":".$_POST['minute'];
    $reserve->setStartTime($_POST['startTime']);

    //コース
    $reserve->setCourse($_POST['course']);

    if($reserve->getCourse() == 4) {
        $reserve->setCourse_flag(true);

        // Array処理が必要です。AMPとの調整が必要
        $dishName = array($_POST['dishName'][0],$_POST['dishName'][1],$_POST['dishName'][2],$_POST['dishName'][3]);
        $reserve->setCourse_4($dishName);
    }
}*/

?>
