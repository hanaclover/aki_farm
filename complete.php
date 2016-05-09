<html>
<head>
<meta charset="UTF-8">
<link rel="stylesheet" type="text/css" href="css/style.css" />
</head>
<body>
<div id="wrapper">
<?php include_once('./common/header.html'); ?>
<?php include_once('./common/nav.html'); ?>
<h1>
御予約ありがとうございました。<br>
ご来店をお待ちしております。<br>
</h1>
<form action="Reserved.php" method="get">
    <input type="submit" name="GoHome" value="ホームへ" />
</form>
<?php include_once('./common/footer.html'); ?>
</div>
</body>
</html>
