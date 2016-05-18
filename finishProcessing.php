<?php
/**
 * Created by PhpStorm.
 * User: SooJu
 * Date: 2016-05-02
 * Time: 오후 12:50
 */

//確定か修正かを確認

//IF(確定)の場合、
//データベースに保存 ->メールを送る -> complete.htmlに移動
include_once("./class/Reserve.php");
include_once("./class/SendMail.class.php");
include_once "./class/UserModel.php";
include_once "./class/ReserveModel.php";

if($_POST['confirm'] == "修正") {
    echo "<script>history.go(-2);</script>";
}

    //RIDを付与する作業
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
        $dishName = array($_SESSION['dish'][0],$_SESSION['dish'][1],$_SESSION['dish'][2],$_SESSION['dish'][3]);
        $reserve->setCourse_4($dishName);
    }

    // <----------- ModelClassでDataBaseに入れる

    //席を決めてSIDを付与する作業
    $rModel = new ReserveModel();
    $uModel = new UserModel();
    $reserve->setSID((string)($rModel->confirmReserve($reserve))); // 予約ができるか確認だけ?


    //changeReserve( $id , $res )
    if($_SESSION['stat'] == 'Change') {
//        $pdo = new PDODatabase();
//        $arr = array($_SESSION['familyName'],$_SESSION['firstName'],$_SESSION['familyName_kana'],$_SESSION['firstName_kana'],$_SESSION['phoneNumber'],$_SESSION['mail']);
//        $res = $pdo->select("user", "", "FamilyName = ? and FirstName = ? and FamilyName_kana = ? and FirstName_kana =? and PhoneNum = ? and Mail = ?", $arr);

        if($_GET['confirm'] == "削除") {
            $reserve->setUID($_SESSION['UID']);
            $rModel->deleteReserve( $_SESSION['RID']);
        } else {
            $reserve->setUID($_SESSION['UID']);
            $rModel->changeReserve( $_SESSION['RID'] , $reserve );
        }
        // uid가 부여되어있는 경우 -> login의 경우임
        //$rModel->setReserve($reserve); 이걸 안하면 uid 가 0으로 들어감 ...!

    } else if($_SESSION['stat'] == 'Reserve') {
        // session - uid가 0 인 경우

        $uModel->setUser();

        $pdo = new PDODatabase();
        $arr = array($_SESSION['familyName'],$_SESSION['firstName'],$_SESSION['familyName_kana'],$_SESSION['firstName_kana'],$_SESSION['phoneNumber'],$_SESSION['mail']);
        $res = $pdo->select("user", "", "FamilyName = ? and FirstName = ? and FamilyName_kana = ? and FirstName_kana =? and PhoneNum = ? and Mail = ?", $arr);

        // uid가 부여되어있는 경우 -> login의 경우임
        $reserve->setUID($res[0]['UID']);

        $rModel->setReserve($reserve);
    }


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

    if($_SESSION['stat'] == 'Reserve') {
        echo "<script> window.location.href = './complete.php' </script>";
    } else if($_SESSION['stat'] == 'Change') {
        if($_POST['confirm'] == "変更確定") {
            echo "<script> window.location.href = './deleteComplete.php?confirm=変更' </script>";
        } else if($_GET['confirm'] == "削除") {
            echo "<script> window.location.href = './deleteComplete.php?confirm=削除' </script>";
        }

    }

?>
