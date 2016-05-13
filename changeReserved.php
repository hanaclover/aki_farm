<?php
/**
 * Created by PhpStorm.
 * User: SooJu
 * Date: 2016-04-28
 * Time: 오후 4:45
 */
//予約ページ
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
    <title>予約変更</title>
    <script src="lib/jquery-2.2.3.min.js"></script>
    <script src="js/management.js"></script>
    <link rel="stylesheet" type="text/css" href="css/style.css" />
    <?php

    require_once "./class/PDODatabase.class.php";

    date_default_timezone_set("Asia/Tokyo");

    $pdo = new PDODatabase();

    $rid = isset($_GET['RID']) ? $_GET['RID'] : '';
    echo $_GET['RID']."+".$rid;
    $arr = array($rid);
    $res = $pdo->select("user u, reserve r", "", "RID = ?", $arr);
    ?>
</head>
<body>
<div id="wrapper">
    <h1>予約変更/取消</h1>
    <form action="http://localhost/aki_farm/aki_farm/confirm.php" method="post">
        <table border="1">
            <tr>
                <td>日にち</td>
                <td>
                    <?php echo "<input type='date' name='Date' value='".$res[0]['StartDay']."' />"; ?>
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
                            echo "<option value='$i' selected>$i</option>";
                        else
                            echo "<option value='$i'>$i</option>";
                    }
                    echo "</select>分";
                    ?>
                </td>
            </tr>
            <tr>
                <td>人数</td>
                <td>
                    <?php echo "<input type='number' name='peopleNum' value='".$res[0]['PeopleNum']."' />"; ?></td>
            </tr>
            <tr>
                <td>漢字名前</td>
                <td>
                    <?php echo "<input type='text' name='familyName' value='".$res[0]['FamilyName']."' />"; ?>
                    <?php echo "<input type='text' name='firstName' value='".$res[0]['FirstName']."' />"; ?>

                </td>
            </tr>
            <tr>
                <td>ふりがな</td>
                <td>
                    <?php echo "<input type='text' name='familyName_kana' value='".$res[0]['FamilyName_kana']."' />"; ?>
                    <?php echo "<input type='text' name='firstName_kana' value='".$res[0]['FirstName_kana']."' />"; ?>
                </td>
            </tr>
            <tr>
                <td>電話番号</td>
                <td>

                    <?php
                    echo "<select name='phoneNum1'>";
                    $firstPN = array("080", "070", "090");

                    $PhoneNum = explode("-", $res[0]['PhoneNum']);

                    //080 070 090
                        for($i = 0; $i < count($firstPN); $i++) {
                            if($firstPN[$i] == $PhoneNum[0])
                                echo "<option value='$firstPN[$i]' selected>$firstPN[$i]</option>";
                            else
                                echo "<option value='$firstPN[$i]'>$firstPN[$i]</option>";
                        }
                        echo "</select>-";

                    echo "<input type='number' name='phoneNum2' value='".$PhoneNum[1]."' />-";
                    echo "<input type='number' name='phoneNum3' value='".$PhoneNum[2]."' />";
                    ?>
                </td>
            </tr>
            <tr>
                <td>メール</td>
                <td>
                    <?php echo "<input type='text' name='mail' value='".$res[0]['Mail']."' />"; ?>
                </td>
            </tr>
            <tr>
                <td>コース名</td>
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
                if($res[0]['Course_flag'] !== false) {
                    echo "<tr>
                            <td>備考</td>
                            <td>".($res[0]['Course_4'] == '' ? '' : $res[0]['Course_4'])."</td>
                        </tr>";
                }
            ?>
        </table>
        <input type="submit" name="send" value="修正" />
        <input type="submit" name="send" value="取消" />
        <input type="submit" name="back" value="戻る" />
    </form>
    <?php include_once('./common/footer.html'); ?>
</div>
</body>
</html>