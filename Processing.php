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
include_once "./class/UserModel.php";
include_once "./class/ReserveModel.php";

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
   // var_dump($_SESSION);
   // var_dump($_POST);
   // echo "</pre>";

    // <----------- ModelClassでDataBaseに入れる

    //席を決めてSIDを付与する作業

    $msg="";
    $rModel = new ReserveModel();
    $uModel = new UserModel();
    $reserve->setSID((string)($rModel->confirmReserve($reserve)));
//    if (($reserve->getSID()) == 0){
//        $msg = "予約できませんでした!";
//    }else{
    $msg = "予約できました!";
    $rModel->setReserve($reserve);
    $uModel->setUser();
//    }
//    echo $msg;

    // ----------->


    // <----------- メールを送る
        //クライアント用のメール送信
    $sendMail = new SendMail(); 
    // 第一引数でcustomerもしくはhostを指定することで送り先ごとに作成するメール内容を変更する。
    $contents = $sendMail->makeContents( 'customer', $reserve->getRID(), $reserve->getReservedTime() );
    // 送信先のメールアドレスとメール内容を指定してメール送信
    $sendMail->sendMail( $_SESSION['mail'], $contents );

        //店舗用のメール送信 詳細はクライアント用のメール送信を参照
    $to = 'tosi_kai_tosi@yahoo.co.jp';
    $sendAki = new SendMail(); 
    $contents = $sendAki->makeContents( 'host', $reserve->getRID(), $reserve->getReservedTime() );
    $sendAki->sendMail( $to, $contents );
    // ----------->

//    if($msg == ""){}
    // 処理が終わりましたらComplete.phpに移動します。
    // echo "<script> window.location.href = 'http://localhost/aki_farm/aki_farm/aki_farm/complete.php?msg='+\"$msg\"; </script>";
   echo "<script> window.location.href = 'http://localhost/aki_farm/aki_farm/aki_farm/complete.php' </script>";
>>>>>>> 7e6b8a101ff0cb09c11a218a5cdad0594ae151bc

} else if($_POST['confirm'] == "修正") {
    echo "<script>history.go(-2);</script>";
}
?>
