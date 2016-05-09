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

    public function getSeat( $peopleNum ) {
         
        /*
         * フィルターの条件（無名関数）をセット
         * 関数のリターン値が true 場合、フィルタリング後の結果セットに格納される
         */
        $filter_func = function ($value) use ($peopleNum) { return ($value >= $peopleNum); };
         
        /*
         * array_filter 関数でフィルタリング
         */
        $result = array_filter($this->arrTable, $filter_func);
         
        // 使用可能なテーブルの配列をソート
        asort($result);
        return $result;
    }
    
}


?>
