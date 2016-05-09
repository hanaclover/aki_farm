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
$db = new PDODatabase();
$seat = new SeatModel($db);
$test = $seat->getSeat(27);
echo "<pre>";
var_dump($test);
echo "</pre>";
*/
class SeatModel {
    
    public $db = NULL;
    private $arrTable = array();

    public function __construct( $db ) {
        $this->db = $db;
        $table =' seat ';
        $col = ' SID, maxPeople ';
        $this->arrTable = $this->db->select( $table, $col );
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

    public function getSeat( $peopleNum ) {
        // 使用可能なテーブルを抽出
        foreach($this->arrTable as $arrTableInfo) {
            if($arrTableInfo['maxPeople'] >= $peopleNum) {
                $result[] = $arrTableInfo['SID'];
            }
        }
        // 連結部の判断
        if($peopleNum <= 18) {
            $result[] = 31; $result[] = 32; $result[] = 33;
        }elseif($peopleNum <= 28) {
            $result[] = 33;
        }
        return $result;



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
  
}

?>
