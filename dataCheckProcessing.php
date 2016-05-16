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
require_once "class/ReserveModel.php";

// uid는 유저가 로그인 하면 들어오는 값임, 세션아이디와는 별개
// 데이터는 일단 유효한 값인지, 형식은 올바른지 체크
$startTime = $_POST['hour'].":".$_POST['minute'].":00";     //  15:00:00 형식으로 맞춰줌
$phoneNumber = $_POST['phoneNum1']."-".$_POST['phoneNum2']."-".$_POST['phoneNum3']; // 000-0000-0000으로 맞춰줌

// post 데이터가 넘어오면 세션에 저장
// 4, true의 경우 AMP페이지로
// 7,10의 경우 confirm 페이지로

//　LOGINの場合、UIDある、GUESTの場合0を入れます。→　ユーザーを登録した後、GUESTのUIDをDBからとってきて予約登録します。
// 変更があるかもしれないので、FORMの内容をSESSIONに入れる
$_SESSION['UID']                = (isset($_SESSION['UID']) ? $_SESSION['UID'] : 0);
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

echo $_POST['course_flag']."course_flag";

// Input Data Check
$_SESSION['err'] = inputDataCheck($_SESSION['UID'], $_SESSION['peopleNum'], $_SESSION['StartDay'],
                        $_SESSION['startTime'],$_SESSION['phoneNumber'], $_SESSION['familyName'], $_SESSION['firstName'],
                        $_SESSION['familyName_kana'], $_SESSION['firstName_kana'], $_SESSION['mail']);

// 座席チェック
$rModel = new ReserveModel();
$reserve = new Reserve();
$reserve->setPeopleNum($_SESSION['peopleNum']);
$reserve->setStartDay($_SESSION['StartDay']);
$reserve->setStartTime($_SESSION['startTime']);
$reserve->setSID((string)($rModel->confirmReserve($reserve)));
var_dump($reserve);
if (($reserve->getSID()) == 0) {

    $_SESSION['full'] = "予約が埋まっております。大変申し訳ございません。<br>よろしければ" .
        "姉妹店をご利用いただけますと幸いです。";
}

if(count($_SESSION['err']) == 0 && (!isset($_SESSION['full']) || $_SESSION['full'] == '')) {
    // エラーがないとき、確認ページに移動する

    echo "<br><br>いけてます";
    if($_SESSION['course_flag'] == true) {
        // AMPのDISH選択ページに行く
        echo "<script>window.location.href = './AMP.php';</script>";
    } else {
        echo "<script>window.location.href = './confirm.php';</script>";
    }

}
else {
    // 間違ったとき、以前のページに移動
    // SESSION変数にERRメッセージを持っている
    echo "<script>history.go(-1);</script>";
}

function inputDataCheck($_uid, $_peopleNum, $_startDay, $_startTime, $_phoneNum, $_familyName, $_firstName, $_familyName_kana, $_firstName_kana, $_mail) {

    $inputDate = array();

    if(preg_match( '/[0-9]+/', $_uid ));
    else $inputDate['UID'] = "登録されたユーザーデータがありません";

    $parseDate = explode("-", $_startDay);

    if(preg_match( '/([2-9]{1}[0-9]{3})/', $parseDate[0] ) &&
        checkdate( $parseDate[1], $parseDate[2], $parseDate[0] )) {
    } else $inputDate['StartDay'] = "日付は正しく入力してください";

    if(preg_match( '/([0-9]{2}):([0-9]{2}):([0-9]{2})/', $_startTime )) {
    } else $inputDate['StartTime'] = "時刻は正しく入力してください";

    if( $_peopleNum > 0 && $_peopleNum <= 30 );
    else $inputDate['peopleNum'] = "お客様の人数は1～30人でお願いします";

    if ( preg_match( '/([0-9]{3})-([0-9]{4})-([0-9]{4})/', $_phoneNum ));
    else $inputDate['phoneNum'] = "電話番号は、半角数字で11桁以内で入力してください";

    if( $_familyName == '' || $_firstName == '')  {
        $inputDate['Name'] ="名前を入力してください";
    }
    if( $_familyName_kana == '' || $_firstName_kana == '')  {
        $inputDate['Name_kana'] ="ふりがなを入力してください";
    }
    if ( preg_match('/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+[a-zA-Z0-9\._-]+$/', $_mail ) === 0 )
    {
        $inputDate['mail'] = 'メールアドレスを正しい形式で入力してください';
    }
    return $inputDate;
}
?>
