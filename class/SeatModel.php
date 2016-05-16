<?php
/*
 *
 * SeatModel.php
 * made by Hana,20160509
 *
*/
/* テスト用
include_once("BaseModel.php");
include_once("PDODatabase.class.php");
include_once("init.php");
$db = new PDODatabase();
$seat = new SeatModel($db);
$test = $seat->getSeat(27);
echo "<pre>";
var_dump($test);
echo "</pre>";
*/

require_once "./class/PDODatabase.class.php";

class SeatModel {
    
    public $db = NULL;
    private $arrTable = array();
    private $jointTableStartNum = 100;
    private $arrJointTableSID = array(7,8,9); 
    private $plus = 2;
    
    public function __construct( PDODatabase $db ) {
        $this->db = $db;
        $table =' seat ';
        $col = ' SID, maxPeople ';
        $this->db->setOrder("MaxPeople");
        $this->arrTable = $this->db->select( $table, $col );
        $this->db->setOrder("");
    }
   
    // 結合したテーブルの仮想SIDのスタートNoを取得
    public function getJointTableStartNum() {
        return $this->jointTableStartNum;
    }

    // 結合可能なテーブルのSIDを取得
    public function getJointTableSID() {
        return $this->arrJointTableSID;
    }

    // maxPeople の取得
    public function getMaxPeople( $SID ) {
         $table  = ' seat ';
         $col    = ' maxPeople ';
         $where  = ( $SID !== '' ) ? ' SID = ? ': '';
         $arrVal = ( $SID !== '' ) ? array( $SID ) :array();
 
         $res = $this->db->select( $table, $col, $where, $arrVal );
         return ( $res !== false && count( $res ) !== 0 ) ? $res[0]['maxPeople'] :     false;
 
    }
//    public function getSeat ( $peopleNum ) {
//        $table =' seat ';
//        $col = ' SID ';
//        $where = ' maxPeople >= ? ';
//        $arrVal = array( $peopleNum );
//
//        $res = $this->db->select( $table, $col, $where, $arrVal );
//        return ( count( $res ) !== 0 ) ? $res : false;
//    }

    // 予約人数を引数として与えることで使用可能な座席のSIDを返す。（予約状況は考慮しない）
    public function getSeat( $peopleNum ) {
        // 連結なしで使用可能なテーブルを抽出し、SIDを返す
        foreach($this->arrTable as $arrTableInfo) {
            if($arrTableInfo['maxPeople'] >= $peopleNum) {
                $result[] = $arrTableInfo['SID'];
            } else {
                $result = array();
            }
        }
        
        // 連結部の判断の処理
         // SID:100以降に連結したテーブルを割り当て(昇順に割り当て）
         // 例）7-8-9連結
         // 7-8  =>SID:100
         // 7-9  =>SID:101
         // 8-9  =>SID:102
         // 7-8-9=>SID:103

        // テーブルの組合せを求める
        $result = array_merge($result,$this->addVirtualSID($peopleNum));  
        
        /*
        $count = count($this->arrJointTableSID);
        for($k=2;$k<=$count;$k++) {
            $temps[]=$this->conbination($k);
        }
        foreach($temps as $tmp){
            foreach($tmp as $temp) {
                $arrJointPattern[] = implode(',', $temp);
            }
        }

        //echo "<pre>";
        //var_dump($arrJointPattern);
        //echo "</pre>";
        
        //$result[] = $this->addVirtualSID( $arrJointPattern );
        */
        return $result;
    }

    public function conbination() {
        $arrJointTableSID = $this->arrJointTableSID;
        $count = count($arrJointTableSID);
        for($i=$count;$i>=0;$i--) {
            $res[] = array_slice($arrJointTableSID,0,$i);
            //array_shift($arrJointTableSID);
        }
        foreach($res as $temp){
             $result = implode($temp);
        }
        var_dump($result);
    }

/*

    // 座席の連結のパターンを作成
        // 第一引数：連結させる座席数
        // 第二引数：結合するテーブルのSID
    public function conbination( $useTableNum, $arrJointTableSID =  '' ) {
        // 引数で$this->arrJointTableSIDをしてするとエラーがでたので改めて定義
        if($arrJointTableSID == '') { $arrJointTableSID = $this->arrJointTableSID; }
        //  連結可能のテーブル数のカウント
        $countJointTableNum = count( $arrJointTableSID );
    
        // テーブルの連結の組み合わせを得る
            // 引数のエラーチェック
        if( $countJointTableNum < $useTableNum ) {
            return 'テーブル数より連結させたいテーブルが多いよ！';
        }elseif( $useTableNum == 1 ) { // 連結したいテーブル数が'1'の>    とき配列を成形するだけ
            for($i=0;$i<$countJointTableNum;$i++){
                arrRes[$i] = array($arrJointTableSID[$i]);
            }
        }elseif( $useTableNum > 1 ) {
        // 連結する組み合わせを求める
            $j = 0;
            for($i=0;$i<$countJointTableNum-$useTableNum+1;$i++){
                // 再帰処理
                $arrTemp = $this->conbination($useTableNum-1, array_slice($arrJointTableSID,$i+    1));
                foreach($arrTemp as $temp){
                    array_unshift($temp,$arrJointTableSID[$i]);
                    $arrRes[$j] = $temp;
                    $j++;
                }
            }
        }
        return $arrRes;
    }
*/
    public function addVirtualSID($peopleNum) {
        $count = count($this->arrJointTableSID);
        $maxNum = $this->getMaxPeople($this->arrJointTableSID[0]);
        // 連結したテーブルに対して利用可能かを判断して仮想SIDを付与
        switch( $count ) {
        case 3:
            if($peopleNum <= $maxNum*2+$this->plus) {
                $result[] = $this->jointTableStartNum; $result[] = $this->jointTableStartNum+1; $result[] = $this->jointTableStartNum+2;
            }elseif($peopleNum <= $maxNum*3+$this->plus*2) {
                $result[] = $this->jointTableStartNum+2;
            }
        break;
        case 2:
            if($peopleNum <= $maxNum*2+$this->plus) {
                $result[] = $this->jointTableStartNum; 
            }
        break;
        }
        return ( !empty($result) !== false ) ? $result : $result = array();

    }

    public function getSeatNumfromSID($sid){
        $arrSeat = array($sid);
        $seatID = $this->db->select("seat" , "sNum" , "SID=?" , $arrSeat);
        $seatNum = $seatID[0]["sNum"];
        return $seatNum;
    }
//         /*
//         * フィルターの条件（無名関数）をセット
//         * 関数のリターン値が true 場合、フィルタリング後の結果セットに格納される
//         */
//        $filter_func = function ($value) use ($peopleNum) { return ($value >= $peopleNum); };
//         
//        /*
//         * array_filter 関数でフィルタリング
//         */
//        $result = array_filter($this->arrTable, $filter_func);
//         
//        // 使用可能なテーブルの配列をソート
//        asort($result);
//        return $result;
  
}

?>
