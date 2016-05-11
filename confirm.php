<?php
/**
 * Created by PhpStorm.
 * User: Owner
 * Date: 2016/05/01
 * Time: 16:49
 */

//予約が確定され、SIDとRIDが付与されてるとき
include_once("class/Reserve.php");
$reserve = new Reserve();
session_start();
echo session_id()."<br>";
// <----
$reserve->setUID($_SESSION['UID']);
// $reserve->setRID($_POST['RID']);     일단 없는 상태로 진행
// $reserve->setSID($_POST['SID']);     일단 없는 상태로 진행
// ---->

$peopleNum = (int)$_SESSION['peopleNum'];
$reserve->setPeopleNum($peopleNum);
$reserve->setReservedTime(date("Y-m-d H:i:s"));
$reserve->setStartDay($_SESSION['Date']);

//StartTimeをTime型化
$startTime = $_SESSION['hour'].":".$_SESSION['minute'].":00";
$reserve->setStartTime($startTime);

//コース
$reserve->setCourse($_SESSION['course']);

if($reserve->getCourse() == 4) {
    $reserve->setCourse_flag(true);

    // Array処理が必要です。AMPとの調整が必要
    $dishName = array($_SESSION['dishName'][0],$_SESSION['dishName'][1],$_SESSION['dishName'][2],$_SESSION['dishName'][3]);
    $reserve->setCourse_4($dishName);
}

//var_dump($reserve);

    if(count($reserve->errCheck()) !== 0) {
        $arr = $reserve->errCheck();
        /*echo  "<script>
                    window.location.href = 'http://localhost/aki_farm/aki_farm/Reserved.php?err=$arr[0]';
               </script>";*/
    }

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <script src="lib/jquery-2.2.3.min.js"></script>
    <script src="js/confirm.js"></script>
    <link rel="stylesheet" type="text/css" href="css/confirm.css">
    <link rel="stylesheet" type="text/css" href="css/style.css"> 
    <title>ご予約内容のご確認</title>
</head>
<body>
<div id="wrapper">
 <?php include_once('./common/header.html'); ?>
 <?php include_once('./common/nav.html'); ?>
    <h1>
        以上の内容でよろしいですか？
    </h1>
    <table class="confirm">
        <tr>
            <td>
                来店日時
            </td>
            <td>
                <?php
                    echo $_SESSION['startTime'];
                ?>
            </td>
        </tr>
        <tr>
            <td>
                人数
            </td>
            <td>
                <?php echo $_SESSION["peopleNum"]; ?>
            </td>
        </tr>
        <tr>
            <td>
                代表者氏名
            </td>
            <td>
                <?php echo $_SESSION["familyName"]." ".$_SESSION["firstName"]."(".$_SESSION['familyName_kana']." ".$_SESSION['firstName_kana'].")"; ?>
            </td>
        </tr>
        <tr>
            <td>
                電話番号
            </td>
            <td>
                <?php echo $_SESSION['phoneNumber']; ?>
            </td>
        </tr>
        <tr>
            <td>
                コース名
            </td>
            <td>
                <?php echo $_SESSION['course']."品"; ?>
            </td>
        </tr>
        <tr>
            <td id="no_under_white">
                メールアドレス
            </td>
            <td>
                <?php echo $_SESSION['mail']; ?>
            </td>
        </tr>
    </table>
    <div class="btns">
        <form action="Processing.php" method="POST">
            <input type='hidden' name='Date' value="<?php echo $_SESSION['Date']; ?>" />
            <input type='hidden' name='hour' value="<?php echo $_SESSION['hour']; ?>" />
            <input type='hidden' name='minute' value="<?php echo $_SESSION['minute']; ?>" />
            <input type='hidden' name='peopleNum' value="<?php echo $_SESSION["peopleNum"]; ?>" />
            <input type='hidden' name='course' value="<?php echo $_SESSION['course']; ?>" />
            <input type="hidden" name="reservedTime" value="<?php echo date("Y-m-d H:i:s"); ?>" />
        <span class="btn"><input type="submit" name="confirm" value="確定" class="common_btn submit"></span>
        <span class="btn"><input type="submit" name="confirm" value="修正" class="common_btn modify"></span>
    </div>
    </form>
<?php include_once('./common/footer.html'); ?>
</div>
</body>
</html>
