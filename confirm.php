<?php
/**
 * Created by PhpStorm.
 * User: Owner
 * Date: 2016/05/01
 * Time: 16:49
 */
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
                    $StartTime = $_POST["Date"]." ".$_POST["hour"].":".$_POST["minute"];
                    echo $StartTime;
                ?>
            </td>
        </tr>
        <tr>
            <td>
                人数
            </td>
            <td>
                <?php echo $_POST["peopleNum"]; ?>
            </td>
        </tr>
        <tr>
            <td>
                代表者氏名
            </td>
            <td>
                <?php echo $_POST["familyName"]." ".$_POST["firstName"]."(".$_POST['familyName_kana']." ".$_POST['firstName_kana'].")"; ?>
            </td>
        </tr>
        <tr>
            <td>
                電話番号
            </td>
            <td>
                <?php echo $_POST['phoneNum1']."-".$_POST['phoneNum2']."-".$_POST['phoneNum3']; ?>
            </td>
        </tr>
        <tr>
            <td>
                コース名
            </td>
            <td>
                <?php echo $_POST['course']."品"; ?>
            </td>
        </tr>
        <tr>
            <td id="no_under_white">
                メールアドレス
            </td>
            <td>
                <?php echo $_POST['mail']; ?>
            </td>
        </tr>
    </table>
    <div class="btns">
        <form action="Processing.php" method="POST">
            <input type='hidden' name='Date' value="<?php echo $_POST['Date']; ?>" />
            <input type='hidden' name='hour' value="<?php echo $_POST['hour']; ?>" />
            <input type='hidden' name='minute' value="<?php echo $_POST['minute']; ?>" />
            <input type='hidden' name='peopleNum' value="<?php echo $_POST["peopleNum"]; ?>" />
            <input type='hidden' name='course' value="<?php echo $_POST['course']; ?>" />
            <input type="hidden" name="reservedTime" value="<?php echo date("Y-m-d H:i:s"); ?>" />
        <span class="btn"><input type="submit" name="confirm" value="確定" class="sub submit"></span>
        <span class="btn"><input type="submit" name="confirm" value="修正" class="sub modify"></span>
    </div>
    </form>
<?php include_once('./common/footer.html'); ?>
</div>
</body>
</html>