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
session_start();

if($_POST['confirm'] == "確定") {

    //RIDを付与する作業

    $_SESSION['startTime'];
    //予約が確定され、SIDとRIDが付与されてるとき
    $reserve = new Reserve();
    $reserve->setUID($_SESSION['UID']);

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

    // <----------- ModelClassでDataBaseに入れる

    //席を決めてSIDを付与する作業
    $msg="";
    $rModel = new ReserveModel();
    $uModel = new UserModel();
    $reserve->setSID((string)($rModel->confirmReserve($reserve)));
    echo "sagsa3";
    $msg = "予約できました!";

    $uModel->setUser();
    // uid가 0 인 경우

    // 먼저 user 등록 후 등록된  uid가져오기 ... 어떻게?
    // 세션에서 가지고 있는 정보를 다 비교해서 가져오기 -> 나중에 겹치면 ㅈ댐ㅎ
    // 세션 id를 넣어서 작업  젤 정확한데...
    // 젤 마지막 uid를 가져와서 하면되긴한데, 동시에 예약이 진행되었을 경우 부딪힘, 잘못될 가능성이 많음
    // 전화번호랑 

    // uid가 부여되어있는 경우 -> login의 경우임

    $rModel->setReserve($reserve);



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

    echo "sagsa4";
    echo "<script> window.location.href = './complete.php' </script>";

} else if($_POST['confirm'] == "修正") {
    echo "<script>history.go(-2);</script>";
}
?>
