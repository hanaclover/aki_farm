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



if($_POST['confirm'] == "確定") {


    //席を決めてSIDを付与する作業


    //RIDを付与する作業


    //予約が確定され、SIDとRIDが付与されてるとき
    $reserve = new Reserve();

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
    $reserve->setStartTime($_POST['$startTime']);

    //コース
    $reserve->setCourse($_POST['course']);

    if($reserve->getCourse() == 4) {
        $reserve->setCourse_flag(true);

        // Array処理が必要です。AMPとの調整が必要
        $dishName = array($_POST['dishName'][0],$_POST['dishName'][1],$_POST['dishName'][2],$_POST['dishName'][3]);
        $reserve->setCourse_4($dishName);
    }

    // <----------- ModelClassでDataBaseに入れる

    // ----------->

var_dump($reserve);

    // <----------- メールを送る
        //クライアント
    $sendMailClient = new SendMail();
    // メール内容の作成
    $contents = $sendMailClient->makeContents( $reserve );
    // メール送信
    //$sendMailClient->sendMail( $_POST['mail'],'title', $contents );
        //店舗長

    // ----------->


    // 処理が終わりましたらComplete.phpに移動します。
    //echo "<script> window.location.href = 'http://localhost/aki_farm/aki_farm/complete.php'; </script>";

} else if($_POST['confirm'] == "修正") {
   /*
    echo "<form action='Reserved.php' method='post'>

            //入力ページに戻ると入力データが残るべき
            <input type='hidden' name='Date' value=".$_POST['Date']." />
            <input type='hidden' name='hour' value=".$_POST['hour']." />
            <input type='hidden' name='minute' value=".$_POST['minute']." />
            <input type='hidden' name='peopleNum' value=".$_POST['peopleNum']." />
            <input type='hidden' name='course' value=".$_POST['course']." />

            // <-------- セッションの変数でするのかな~?
            <input type='hidden' name='mail' value=".$_POST['mail']." />
            <input type='hidden' name='familyName' value=".$_POST['familyName']." />
            <input type='hidden' name='firstName' value=".$_POST['firstName']." />
            <input type='hidden' name='familyName_kana' value=".$_POST['familyName_kana']." />
            <input type='hidden' name='firstName_kana' value=".$_POST['firstName_kana']." />
            <input type='hidden' name='phoneNum1' value=".$_POST['phoneNum1']." />
            <input type='hidden' name='phoneNum2' value=".$_POST['phoneNum2']." />
            <input type='hidden' name='phoneNum3' value=".$_POST['phoneNum3']." />
            // --------->

          </form>";
   */
}
?>
