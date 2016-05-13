
<?php
/*
 * TestMailSend.php
 * made by hana, 20160510
 *
 *
 *
*/

// -------------test用データ--------------
/*
 * 1.テキストデータ（メールの内容）を読み込む
 * 2.メールアドレス，タイトル，内容，ヘッダーを引数としてメールを送るクラスを作成
 * 3.メール送信
*/
//echo '<meta charset=\'UTF-8\'>';
//$mail = new SendMail();
//$mailContentsPath = 'sample_mail.txt';
//
//
//$to      = 'shanai0126@gmail.com';
//$subject = 'タイトル';
//$header = 'From: Aki農場' . "\r\n";
//$mail->sendMail($to, $subject, $mailContentsPath, $header);
// -------------<end>test用データ-----------

class SendMail {
    private $mailContentsPath;
    private $header;
    private $subject;

    public function __construct() {
        mb_language("Japanese");
        mb_internal_encoding("UTF-8");
        $this->mailContentsPath = './class/sample_mail.txt';
    }

    public function makeContents( $mode, $reserveNum, $reserveTime ) {
        /*
        $fp = fopen($this->mailContentsPath, 'r');
        if ($fp){
            if (flock($fp, LOCK_SH)){
                while (!feof($fp)) {
                    $buffer = fgets($fp);
                    $contents .= $buffer;
                }

                flock($fp, LOCK_UN);
            }else{
                print('ファイルロックに失敗しました');
            }
        }
        fclose($fp);
        */ 
        //echo "<pre>";
        //var_dump($reserveContents);
        //var_dump($contents);
        //var_dump($_SESSION);
        //echo "</pre>";
        $reservecontents = <<<EOS
---------------------------------------------------
予約番号：{$reserveNum}
予約日時：{$reserveTime}
ご来店日時：{$_SESSION['StartDay']} {$_SESSION['startTime']}
御予約人数：{$_SESSION['peopleNum']}
お名前：{$_SESSION['familyName']} {$_SESSION['firstName']} ({$_SESSION['familyName_kana']} {$_SESSION['firstName_kana']})
電話番号：{$_SESSION['phoneNumber']}
御予約コース:{$_SESSION['course']}
お料理：{$_SESSION['course_flag']}
 ※ 4品コースを御選択頂いた場合のみ表示しております。
メールアドレス：{$_SESSION['mail']}
---------------------------------------------------
EOS;
        switch( $mode ) {
        case 'customer':
        $this->subject = '【Aki農場】御予約ありがとうございます';
        $this->header = 'From: Aki農場' . "\r\n";
        $contents = <<<EOS
{$_SESSION['familyName']} 様

この度は『Aki農場』をご利用いただき、
誠にありがとうございます。
以下の通りご予約が完了いたしました。

 ※ 本メールは配信専用のため、ご返信いただきましても
 Aki農場には届きません。

{$reservecontents}

※ 本メールはお客様にご入力いただいたメールアドレスあてに発信しているため、
　入力ミスなどの理由によりまったく別の方にメールが届く可能性があります。
　もし本メールにお心当たりが無い場合は、
　お手数ですが、破棄していただけますようお願いします。

※ 本メールにご返信いただきましても、対応いたしかねます。
お問い合わせは下記のメールアドレスよりお願いいたします。
customer@akifarm.jp
EOS;
        break;

        case 'host':
        $this->subject = "【Aki農場】{$_SESSION['familyName']}様より御予約がありました。";
        $this->header = 'From: Aki農場' . "\r\n";
        $contents = <<<EOS
{$_SESSION['familyName']}様より御予約がありました｡
{$reservecontents}
EOS;
       break;
       } 
         // JIS変換
         $contents = mb_convert_encoding( $contents, "ISO-2022-JP", "auto" );
        return $contents;
    }

    public function sendMail($to, $contents ) {
        // メールを送信（現在ローカル環境の為，送信不可．
        if( !mb_send_mail($to, $this->subject, $contents, $this->header)) { echo 'メールの送信に失敗しました。'; }
	else { echo 'succsess';}
        }
}


?>
