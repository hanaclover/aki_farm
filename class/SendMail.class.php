
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

    public function __construct() {
        mb_language("Japanese");
        mb_internal_encoding("UTF-8");
        $this->mailContentsPath = 'sample_mail.txt';
        $this->header = 'From: Aki農場' . "\r\n";
    }

    public function makeContents( $reserveContents ) {
        $contents = '';
	// ファイルの読み込み方は変更します。
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

        echo "<pre>";
        var_dump($reserveContents);
        echo "</pre>";

        return $contents;
    }
    public function sendMail($to, $subject, $contents ) {
        // メールを送信（現在ローカル環境の為，送信不可．
        if( !mb_send_mail($to, $subject, $contents, $this->header)) { echo 'メールの送信に失敗しました。'; }
	else { echo 'succsess';}
        }
}


?>
