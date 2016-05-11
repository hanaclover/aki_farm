<?php
/**
 * Created by PhpStorm.
 * User: SooJu
 * Date: 2016-05-02
 * Time: 오후 12:50
 */
// 予約ペ?ジから?けたデ?タを?理

//確定か修正かを確認

//IF(確定)の場合、
//データベースに保存 ->メールを送る -> complete.htmlに移動

include_once("./class/Reserve.php");

if($_POST['confirm'] == "確定") {


    //席を決めてSIDを付与する作業


    //RIDを付与する作業


    //予約が確定され、SIDとRIDが付与されてるとき
    $reserve = new Reserve();

    // <----
    //$reserve->setUID($_POST['UID']);
    // $reserve->setRID($_POST['RID']);     일단 없는 상태로 진행
    // $reserve->setSID($_POST['SID']);     일단 없는 상태로 진행
    // ---->
    $peopleNum = (int)$_POST['peopleNum'];
    $reserve->setPeopleNum($peopleNum);
    $reserve->setReservedTime(date("Y-m-d H:i:s"));
    $reserve->setStartDay($_POST['Date']);

    //StartTimeをTime型化
    $startTime = $_POST['hour'].":".$_POST['minute'].":00";
    $reserve->setStartTime($startTime);

    //コース
    $reserve->setCourse($_POST['course']);

    if($reserve->getCourse() == 4) {
        $reserve->setCourse_flag(true);

        // Array処理が必要です。AMPとの調整が必要
        $dishName = array($_POST['dishName'][0],$_POST['dishName'][1],$_POST['dishName'][2],$_POST['dishName'][3]);
        $reserve->setCourse_4($dishName);
    }

    // var_dump($reserve);

    // <----------- ModelClassでDataBaseに入れる

    // ----------->



    // <----------- メールを送る
        //クライアント

        //店舗長

    // ----------->


    // 処理が終わりましたらComplete.phpに移動します。
    echo "<script> window.location.href = 'http://localhost:63342/aki_farm/aki_farm/complete.php'; </script>";

} else if($_POST['confirm'] == "修正") {
    echo "<script>history.go(-2);</script>";
}
?>