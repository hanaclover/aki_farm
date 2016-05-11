<?php
/**
 * Created by PhpStorm.
 * User: SooJu
 * Date: 2016-05-10
 * Time: 오후 12:06
 */
?>
<?php
include_once("class/Reserve.php");

echo "testProcessing : ".session_id()."<br>";

// uid는 유저가 로그인 하면 들어오는 값임, 세션아이디와는 별개
// 데이터는 일단 유효한 값인지, 형식은 올바른지 체크
$startTime = $_POST['hour'].":".$_POST['minute'].":00";     //  15:00:00 형식으로 맞춰줌
$phoneNumber = $_POST['phoneNum1']."-".$_POST['phoneNum2']."-".$_POST['phoneNum3']; // 000-0000-0000으로 맞춰줌

// post 데이터가 넘어오면 세션에 저장
// 4, true의 경우 AMP페이지로
// 7,10의 경우 confirm 페이지로

$_SESSION['UID']                = 0;
$_SESSION['StartDay']           = $_POST['Date'];
$_SESSION['startTime']          = $startTime;
$_SESSION['peopleNum']          = $_POST['peopleNum'];
$_SESSION['familyName']         = $_POST['familyName'];
$_SESSION['firstName']          = $_POST['firstName'];
$_SESSION['familyName_kana']    = $_POST['familyName_kana'];
$_SESSION['firstName_kana']     = $_POST['firstName_kana'];
$_SESSION['phoneNumber']        = $phoneNumber;
$_SESSION['mail']               = $_POST['mail'];
$_SESSION['course']             = $_POST['course'];

if($_POST['course'] == "4") {
    $_SESSION['course_flag'] = true;
} else $_SESSION['course_flag'] = false;

// Input Data Check
$_SESSION['err'] = inputDataCheck($_SESSION['UID'], $_SESSION['peopleNum'], $_SESSION['StartDay'],
                        $_SESSION['startTime'],$_SESSION['phoneNumber'], $_SESSION['familyName'], $_SESSION['firstName'],
                        $_SESSION['familyName_kana'], $_SESSION['firstName_kana'], $_SESSION['mail']);


if(count($_SESSION['err']) == 0) {
    // エラーがないとき、確認ページに移動する

    // 座席チェック


    echo "<script>window.location.href = 'http://localhost/aki_farm/aki_farm/confirm.php';</script>";
}
else {
    // 間違ったとき、以前のページに移動
    // SESSION変数にERRメッセージを持っている
    echo "<script>history.go(-1);</script>";
}
// 데이터를 체크
/*if( count(arr) == 0 ) {
    // data check ok

    if( sid != 0 ) {
        // seat check function


        if($_SESSION['course_flag'] == true) {
            // AMPのDISH選択ページに行く
            //echo "<script>window.location.href = 'http://localhost/...'</script>";
        } else {
            echo "<script>window.location.href = 'http://localhost:63342/aki_farm/aki_farm/confirm.php';</script>";
        }

        // seikai
        // echo "<script>window.location.href = 'http://localhost:63342/aki_farm/aki_farm/confirm.php';</script>";

    } else {
        // not seat
        //alert(座席がありません。時間を変えて下さい。);

        // history.go("Reserved.php?err=notseat");
    }
} else {
    // history.go(-1)
}*/
function inputDataCheck($_uid, $_peopleNum, $_startDay, $_startTime, $_phoneNum, $_familyName, $_firstName, $_familyName_kana, $_firstName_kana, $_mail) {

    $inputDate = array();

    if(preg_match( '/[0-9]+/', $_uid ));
    else $inputDate['UID'] = "UIDがおかしいです。";

    $parseDate = explode("-", $_startDay);

    if(preg_match( '/([2-9]{1}[0-9]{3})/', $parseDate[0] ) &&
        checkdate( $parseDate[1], $parseDate[2], $parseDate[0] )) {
    } else $inputDate['StartDay'] = "StartDayのタイプが間違いました。";

    if(preg_match( '/([0-9]{2}):([0-9]{2}):([0-9]{2})/', $_startTime )) {
    } else $inputDate['StartTime'] = "startTimeのタイプが間違いました。";

    if( $_peopleNum > 0 && $_peopleNum <= 30 );
    else $inputDate['peopleNum'] = "1~30人までです。";

    if ( preg_match( '/([0-9]{3})-([0-9]{4})-([0-9]{4})/', $_phoneNum ));
    else $inputDate['phoneNum'] = "電話番号は、半角数字で11桁以内で入力してください";

    if( $_familyName == '' || $_firstName == '')  {
        $inputDate['Name'] ="確認お願いいたします。";
    }
    if( $_familyName_kana == '' || $_firstName_kana == '')  {
        $inputDate['Name_kana'] ="確認お願いいたします。";
    }
    if ( preg_match('/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+[a-zA-Z0-9\._-]+$/', $_mail ) === 0 )
    {
        $inputDate['mail'] = 'メールアドレスを正しい形式で入力してください';
    }
    return $inputDate;
}

/*if($_SESSION['course_flag'] == true) {
    // AMPのDISH選択ページに行く
    //echo "<script>window.location.href = 'http://localhost/...'</script>";
} else {
<<<<<<< HEAD
    echo "<script>window.location.href = 'http://localhost:63342/aki_farm/aki_farm/confirm.php';</script>";
}*/





///////////////////////////////////////////////////////////////////////////////////////////
/*if(count(dataCheck_overlode($_SESSION['course_flag'],$_SESSION['UID'],$_SESSION['peopleNum'],$_SESSION['ReservedTime'],
    $_SESSION['StartDay'],$_SESSION['startTime'],$_SESSION['course'],$_SESSION['course_4'])) == 0 ) {

    $_SESSION['UID'] = 0;
    $_SESSION['peopleNum'] = $_POST['peopleNum'];
    $_SESSION['ReservedTime'] = 0;
    $_SESSION['StartDay'] = $_POST['Date'];
    $_SESSION['startTime'] = $_POST['hour'].":".$_POST['minute'];
    $_SESSION['course'] = $_POST['course'];
    if($_POST['course'] == "4") {
        $_SESSION['course_flag'] = true;
    } else $_SESSION['course_flag'] = false;
}*/
// return Array(Error)
/*function dataCheck_overlode($course_flag, $_uid, $_peopleNum, $_reservedTime, $_startDay, $_startTime, $_course, $_course_4) {

    // $course_flag == false 7, 10
    // $course_flag == true  4
    switch($course_flag) {
        case "false": // 7, 10
            return inputDataCheck($_uid, $_peopleNum, $_reservedTime, $_startDay, $_startTime, $_course);
            break;
        case "true": // 4
            return inputDataCheck_4($_uid, $_peopleNum, $_reservedTime, $_startDay, $_startTime, $_course, $_course_4);
            break;
    }
}*/

/*function inputDataCheck_4 ($_uid, $_peopleNum, $_reservedTime, $_startDay, $_startTime, $_course, $_course_4) {

    $inputDate = array();

    if(preg_match( '/[0-9]+/', $_uid ));
    else $inputDate['err'] = "UIDがおかしいです。";

    $parseDate = explode("-", $_startDay);

    if(preg_match( '/([2-9]{1}[0-9]{3})/', $parseDate[0] ) &&
        checkdate( $parseDate[1], $parseDate[2], $parseDate[0] ));
    else $inputDate['err'] = "StartDayのタイプが間違いました。";

    if(preg_match( '/([0-9]{2}):([0-9]{2}):([0-9]{2})/', $_startTime ));
    else $inputDate['err'] = "startTimeのタイプが間違いました。";


    $parseTimeStamp = explode(" ", $_reservedTime);      //2016-05-09と14:00:00をわけ
    $parseDate      = explode("-", $parseTimeStamp[0]); //2016-05-09を-ことにわけ

    if(preg_match( '/([2-9]{1}[0-9]{3})/', $parseDate[0] ) &&
        checkdate( $parseDate[1], $parseDate[2], $parseDate[0] ) ) {

        if(preg_match( '/([0-9]{2}):([0-9]{2}):([0-9]{2})/', $parseTimeStamp[1] ));

    } else $inputDate['err'] = "ReservedTimeが間違いました。";

    if( $_peopleNum > 0 && $_peopleNum <= 30 );
    else $inputDate['err'] = "peopleNumが間違いました。1~30までです。";

    if($_course == 4 || $_course == 7 || $_course == 10);
    else $inputDate['err'] = "4，7，10だけです。";

    if( count($_course_4) == 4 );
    else $inputDate['err'] = "4個までです。";

    return $inputDate;
}*/
?>
