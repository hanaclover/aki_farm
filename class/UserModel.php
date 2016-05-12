<?php
/* 
 * 
 * BaseModel.php 
 * made by hana,20160509 
 * 
*/ 

/* テスト用
 include_once("BaseModel.php");
 include_once("PDODatabase.class.php");
 $db = new PDODatabase();
 $user = new UserModel($db);
 $FamilyName        = 'testFam';
 $FirstName         = 'testFirst';
 $FamilyName_Kana   = 'ka';
 $FirstName_Kana    = 'na';
 $PhoneNum          = '000-0000-0000';
 $Mail              = 'test@test.com';
 $user->setUser($FamilyName, $FirstName, $FamilyName_Kana, $FirstName_Kana, $PhoneNum, $Mail);
 $test = $user->getUser(3);
 echo "<pre>";
 var_dump($test);
 echo "</pre>";
*/
require_once "./class/PDODatabase.class.php";

class UserModel {
    private $db = NULL;
    
    public function __construct() {
        $this->db = new PDODatabase();
    }

    // 予約一覧用のユーザ情報を取得
    public function getUserBookList( $uId ) {
        $table  = ' user ';
        $col    = ' FamilyName, FirstName, PhoneNum ';
        $where  = ( $uId !== '' ) ? ' UID = ? ': '';
        $arrVal = ( $uId !== '' ) ? array( $uId ) :array();
        
        $res = $this->db->select( $table, $col, $where, $arrVal );
        
        return ( $res !== false && count( $res ) !== 0 ) ? $res : false;
    }

    // データ変更用のユーザ情報を取得
    public function getUser( $uId ) {
        $table  = ' user ';
        $col    = ' * ';
        $where  = ( $uId !== '' ) ? ' UID = ? ': '';
        $arrVal = ( $uId !== '' ) ? array( $uId ) :array();
        
        $res = $this->db->select( $table, $col, $where, $arrVal );
        
        return ( $res !== false && count( $res ) !== 0 ) ? $res : false;
    }


    // ユーザ情報をDBに登録
    public function setUser( $FamilyName = '', $FirstName = '', $FamilyName_Kana = '', $FirstName_Kana = '', $PhoneNum = '', $Mail = '' ) {
       $table = ' user ';
      if(!empty($_SESSION['familyName'])) {
        $insData =  array( 'FamilyName' => $_SESSION['familyName'], 'FirstName' => $_SESSION['firstName'], 'FamilyName_Kana' => $_SESSION['familyName_kana'], 'FirstName_Kana' => $_SESSION['firstName_kana'], 'PhoneNum' => $_SESSION['phoneNumber'], 'Mail' => $_SESSION['mail'] );
      } else {
        $insData =  array( 'FamilyName' => $FamilyName, 'FirstName' => $FirstName, 'FamilyName_Kana' => $FamilyName_Kana, 'FirstName_Kana' => $FirstName_Kana, 'PhoneNum' => $PhoneNum, 'Mail' => $Mail );
       }
       $res = $this->db->insert( $table, $insData );
       return $res; 
    }
}
