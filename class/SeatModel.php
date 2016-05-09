<?php
/*
 *
 * SeatModel.php
 * made by Hana,20160509
 *
*/

class SeatModel {
    
    public $db = NULL;

    public function __construct( $db ) {
        $this->db = $db;
    }

    public function getSeat ( $peopleNum ) {
        $table =' seat ';
        $col = ' SID ';
        $where = ' maxPeople >= ? ';
        $arrVal = array( $peopleNum );

        $res = $this->db->select( $table, $col, $where, $arrVal );
        return ( count( $res ) !== 0 ) ? $res : false;
    }

//    public function getSeat( $peopleNum ) {
//         
//        /*
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
//    }
    
}

?>
