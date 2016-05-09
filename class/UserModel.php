<?php
/* 
 * 
 * BaseModel.php 
 * made by hana,20160509 
 * 
*/ 

// ----------<start>test用----------
require_once('../dbDefine.php');
require_once('BaseModel.php');

$db     = new BaseModel( DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_TYPE );
$user   = new UserModel( $db );

// ----------test用<end>------------

class UserModel {
    public $db  = NULL;
    
    public function __construct( $db ) 
        $this->db = $db;
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
        $col    = ' FamilyName, FirstName, FamilyName_Kana, FirstName_Kana, PhoneNum, Mail ';
        $where  = ( $uId !== '' ) ? ' UID = ? ': '';
        $arrVal = ( $uId !== '' ) ? array( $uId ) :array();
        
        $res = $this->db->select( $table, $col, $where, $arrVal );
        
        return ( $res !== false && count( $res ) !== 0 ) ? $res : false;
    }


    // ユーザ情報をDBに登録
    // public function setUser( $FirstName, $FamilyName) {
    public function setUser( $arrReserveData) {
       $table = ' user ';
       $insData = $arrReserveData; 
      // $insData =  array( 'FamilyName' => $FamilyName, 'FirstName' => $FirstName );
       $res = $this->db->insert( $table, $insData );
       return $res; 
    }
}
