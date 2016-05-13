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
    <title>予約ページ</title>
    <script src="lib/jquery-2.2.3.min.js"></script>
    <script src="js/management.js"></script>
    <script src="js/confirm.js"></script>
    <script src="js/ajax.js"></script>
    <link rel="stylesheet" type="text/css" href="css/style.css" />
    <link rel="stylesheet" type="text/css" href="css/tableForm.css" />
    <link rel="stylesheet" type="text/css" href="css/input.css" />
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
    <h2>予約情報を入力してください。</h2>
    <form action="http://localhost/aki_farm/aki_farm/dataCheckProcessing.php" method="post">
        <span class="err"><?php echo (isset($_GET['err']) ? $_GET['err'] : ""); ?></span>
        <table border="1" class="design_table">
            <!--　SESSIONにErrorメッセージがあるとエラーを表示　-->
            <tr>
                <td>日にち</td>
                <td>
                    <input type="date" name="Date" />
                    <span class="err"><?php echo isset($_SESSION['err']['StartDay']) ? $_SESSION['err']['StartDay'] : "" ; ?></span>
                </td>
            </tr>
            <tr>
                <td>時刻</td>
                <td>
                    <select name="hour">
                        <option selected value="17">17</option>
                        <option value="18">18</option>
                        <option value="19">19</option>
                        <option value="20">20</option>
                        <option value="21">21</option>
                        <option value="22">22</option>
                        <option value="23">23</option>
                    </select>時
                    <select name="minute">
                        <option selected value="00">00</option>
                        <option value="10">10</option>
                        <option value="20">20</option>
                        <option value="30">30</option>
                        <option value="40">40</option>
                        <option value="50">50</option>
                    </select>分
                    <span class="err" id="minute"><?php echo isset($_SESSION['err']['StartTime']) ? $_SESSION['err']['StartTime'] : "" ; ?></span>
                </td>
            </tr>
            <tr>
                <td>人数</td>
                <td>
                    <input type="number" name="peopleNum" class="unsigned" value="" placeholder="1以上の数字を入れてください" />
                    <span class="err"><?php echo isset($_SESSION['err']['peopleNum']) ? $_SESSION['err']['peopleNum'] : "" ; ?></span>
                </td>
            </tr>
            <tr>
                <td>漢字名前</td>
                <td>
                    <input type="text" name="familyName" placeholder="FamilyName" value="" />
                    <input type="text" name="firstName" placeholder="FirstName" value="" />
                    <span class="err"><?php echo isset( $_SESSION['err']['Name'] ) ? $_SESSION['err']['Name'] : "" ; ?></span>
                </td>
            </tr>
            <tr>
                <td>ふりがな</td>
                <td>
                    <input type="text" name="familyName_kana" placeholder="FamilyName"  value="" />
                    <input type="text" name="firstName_kana" placeholder="FirstName"  value="" />
                    <span class="err"><?php echo isset($_SESSION['err']['Name_kana']) ? $_SESSION['err']['Name_kana'] : "" ; ?></span>
                </td>
            </tr>
            <tr>
                <td>電話番号</td>
                <td>
                    <select name="phoneNum1">
                        <option selected value="080">080</option>
                        <option value="090">090</option>
                        <option value="070">070</option>
                    </select>-
                    <input type="number" name="phoneNum2" class="unsigned" value="" />-
                    <input type="number" name="phoneNum3" class="unsigned" value="" />
                    <span class="err"><?php echo isset($_SESSION['err']['phoneNum']) ? $_SESSION['err']['phoneNum'] : "" ; ?></span>
                </td>
            </tr>
            <tr>
                <td>メール</td>
                <td>
                    <input type="text" name="mail" placeholder="abc@gmail.com" value=""  />
                    <span class="err"><?php echo isset($_SESSION['err']['mail']) ? $_SESSION['err']['mail'] : "" ; ?></span>
                </td>
            </tr>
            <tr>
                <td id="no_under_white">コース名</td>
                <td>
                    <input type="radio" name="course" value="4" />4
                    <input type="radio" name="course" value="7" checked="checked" />7
                    <input type="radio" name="course" value="10" />10
                </td>
            </tr>
        </table>
        <input type="submit" name="send" value="予約" class="common_btn submit"/>
    </form>
    <?php include_once('./common/footer.html'); ?>
</div>
</body>
</html>
