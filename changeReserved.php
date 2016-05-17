<?php
/**
 * Created by PhpStorm.
 * User: SooJu</label>
 * Date: 2016-04-28
 * Time: 오후 4:45
 */

//予約ページ
/*
 *  ログイン処理
 *
 * 1. 4品の場合 AMPのページに渡す
 * 2. 4品以外の場合　→　ContentsCheck(yyy
 * 3. ContentsCheck() RETURN False　→　RESERVEDに戻る
 * */
echo "Reserved : ".session_id();
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
    <title>予約Modify</title>
    <script src="lib/jquery-2.2.3.min.js"></script>
    <script src="js/management.js"></script>
    <script src="js/confirm.js"></script>
    <script src="js/ajax.js"></script>
    <link rel="stylesheet" type="text/css" href="css/style.css" />
    <link rel="stylesheet" type="text/css" href="css/tableForm.css" />
    <link rel="stylesheet" type="text/css" href="css/input.css" />
    <?php

    require_once "./class/PDODatabase.class.php";

    date_default_timezone_set("Asia/Tokyo");

    $pdo = new PDODatabase();
    $_SESSION['UID'] = isset($_GET['UID']) ? $_GET['UID'] : '';
    echo $_SESSION['UID'];
    $_SESSION['RID'] = isset($_GET['RID']) ? $_GET['RID'] : '';
    $arr = array($_SESSION['RID']);
    $res = $pdo->select("user u, reserve r", "", "RID = ?", $arr);
    ?>
</head>
<body>
<div id="wrapper">
    <?php include_once('./common/header.html'); ?>
    <?php include_once('./common/nav.html'); ?>
    <span id="shimaiten">
        <?php
        if(isset($_SESSION['full'])){
            echo "<p>".$_SESSION['full']."</p>";
            echo "<p><a href='http://meijin-farm.com/welcome/'>Meijin農場</a></p>";
            unset($_SESSION['full']);
        }
        ?>
    </span>
    <h2>予約変更画面</h2>
    <form action="./dataCheckProcessing.php" method="post">
        <span class="err"><?php echo (isset($_GET['err']) ? $_GET['err'] : ""); ?></span>
        <table border="1" class="design_table">
            <!--　SESSIONにErrorメッセージがあるとエラーを表示　-->
            <tr>
                <td>日にち</td>
                <td>
                    <?php echo "<input type='date' name='Date' value='".$res[0]['StartDay']."'>"; ?>
                    <span class="err"><?php echo isset($_SESSION['err']['StartDay']) ? $_SESSION['err']['StartDay'] : "" ; ?></span>
                </td>
            </tr>
            <tr>
                <td>時刻</td>
                <td>
                    <?php
                    $time = explode(":", $res[0]['StartTime']);
                    echo "<select name='hour'>";
                    for($i = 17; $i <= 23; $i++) {
                        if($i == $time[0])
                            echo "<option value='$i' selected>$i</option>";
                        else
                            echo "<option value='$i'>$i</option>";
                    }
                    echo "</select>時";
                    echo "<select name='minute'>";
                    for($i = 00; $i <= 50; $i += 10) {
                        if($i == $time[1])
                            echo "<option value='".sprintf("%02d", $i)."' selected>".sprintf("%02d", $i)."</option>";
                        else
                            echo "<option value='$i'>$i</option>";
                    }
                    echo "</select>分";
                    ?>
                    <span class="err" id="minute"><?php echo isset($_SESSION['err']['StartTime']) ? $_SESSION['err']['StartTime'] : "" ; ?></span>
                </td>
            </tr>
            <tr>
                <td>人数</td>
                <td>
                    <?php
                        $_SESSION['peopleNum'] = $res[0]['PeopleNum'];
                        echo "<input type='number' name='peopleNum' value='".$res[0]['PeopleNum']."' />";
                    ?></td>
                <span class="err"><?php echo isset($_SESSION['err']['peopleNum']) ? $_SESSION['err']['peopleNum'] : "" ; ?></span>
            </tr>
            <tr>
                <td>漢字名前</td>
                <td>
                    <?php
                        $_SESSION['familyName'] = $res[0]['FamilyName'];
                        $_SESSION['firstName'] = $res[0]['FirstName'];
                        echo $res[0]['FamilyName']." ".$res[0]['FirstName'];
                    ?>
                </td>
            </tr>
            <tr>
                <td>ふりがな</td>
                <td>
                    <?php
                        $_SESSION['familyName_kana'] = $res[0]['FamilyName_kana'];
                        $_SESSION['firstName_kana'] = $res[0]['FirstName_kana'];
                        echo $res[0]['FamilyName_kana']." ".$res[0]['FirstName_kana'];
                    ?>
                </td>
            </tr>
            <tr>
                <td>電話番号</td>
                <td>
                <?php
                    $_SESSION['phoneNumber'] = $res[0]['PhoneNum'];
                    echo $res[0]['PhoneNum'];
                ?>
                </td>
            </tr>
            <tr>
                <td>メール</td>
                <td>
                    <?php
                        $_SESSION['mail'] = $res[0]['Mail'];
                        echo $res[0]['Mail'];
                    ?>
                </td>
            </tr>
            <tr>
                <td id="no_under_white">コース名</td>
                <td>
                <?php
                    $order = array("4", "7", "10");

                    for($i = 0; $i < count($order); $i++) {
                        if($order[$i] == $res[0]['Course'])
                            echo "<input type='radio' name='course' value='$order[$i]' checked />$order[$i]";
                        else
                            echo "<input type='radio' name='course' value='$order[$i]' />$order[$i]";
                    }
                ?>
                </td>
            </tr>
            <?php
                if($res[0]['Course_flag'] !== true) {
                    echo "<tr>
                            <td>備考</td>
                            <td>".($res[0]['Course_4'] == '' ? '' : $res[0]['Course_4'])."</td>
                        </tr>";
                }
            ?>
        </table>
        <input type="submit" name="send" value="変更" class="common_btn submit"/>
        <input type="submit" name="send" value="取消" class="common_btn submit"/>
    </form>
    <?php include_once('./common/footer.html'); ?>
</div>
</body>
</html>