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
include_once("./class/SendMail.class.php");
include_once("./class/ReserveModel.php");

if($_POST['confirm'] == "確定") {

    //RIDを付与する作業

    $_SESSION['startTime'];
    //予約が確定され、SIDとRIDが付与されてるとき
    $reserve = new Reserve();
    $reserve->setUID($_SESSION['UID']);

    // <----
    // $reserve->setRID($_POST['RID']);     일단 없는 상태로 진행
    // $reserve->setSID($_POST['SID']);     일단 없는 상태로 진행
    // ---->

    $peopleNum = (int)$_SESSION['peopleNum'];
    $reserve->setPeopleNum($peopleNum);
    $reserve->setReservedTime(date("Y-m-d H:i:s"));
    $reserve->setStartDay($_SESSION['StartDay']);
    $reserve->setStartTime($_SESSION['startTime']);

    //コース
    $reserve->setCourse($_SESSION['course']);

    if($reserve->getCourse() == 4) {
        $reserve->setCourse_flag(true);

        // Array処理が必要です。AMPとの調整が必要
        $dishName = array($_POST['dishName'][0],$_POST['dishName'][1],$_POST['dishName'][2],$_POST['dishName'][3]);
        $reserve->setCourse_4($dishName);
    }
   // echo "<pre>";
   // var_dump($reserve);
   // var_dump($_POST);
   // echo "</pre>";
    // <----------- ModelClassでDataBaseに入れる

    //席を決めてSIDを付与する作業

    $msg="";
    $rModel = new ReserveModel();
    $reserve->setSID((string)($rModel->confirmReserve($reserve)));
    if (($reserve->getSID()) == 0){
        $msg = "予約できませんでした!";
    }else{
        $msg = "予約できました!";
        $rModel->setReserve($reserve);
    }
    var_dump($reserve);
    echo $msg;

    // ----------->


    // <----------- メールを送る
        //クライアント
    // <----テスト用データ
    $to = 'tosi_kai_tosi@yahoo.co.jp';
    // ----->

    $sendMail = new SendMail(); 
    $contents = $sendMail->makeContents( $reserve, 'customer' );
    $sendMail->sendMail( $to, $contents );
        //店舗長

    $sendAki = new SendMail(); 
    $contents = $sendAki->makeContents( $reserve, 'host' );
    $sendAki->sendMail( $to, $contents );
    // ----------->

    if($msg == "")
    // 処理が終わりましたらComplete.phpに移動します。
    echo "<script> window.location.href = 'http://localhost/aki_farm/aki_farm/complete.php?msg='+\"$msg\"; </script>";

} else if($_POST['confirm'] == "修正") {
    echo "<script>history.go(-2);</script>";
}
?>
