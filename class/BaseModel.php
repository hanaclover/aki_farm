<?php
/*
 *
 * BaseModel.php
 * made by Meijin,20160506
 * based on Mr.Aki.
 *
*/
class BaseModel {

    protected $PDO;

    public function __construct() {
        $this->db_connect();
    }

    //----------------------------------------------------
    // データベース接続
    //----------------------------------------------------
    private function db_connect(){
        try {
            $this->PDO = new PDO(_DSN, _DB_USER, _DB_PASS);
            $this->PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->PDO->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        } catch(PDOException $Exception) {
            die('エラー :' . $Exception->getMessage());
        }
    }
    
}

?>