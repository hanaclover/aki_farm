<?php
/**
 * Created by PhpStorm.
 * User: Owner
 * Date: 2016/05/09
 * Time: 10:27
 *
 * 共通クラスであるBaseModelを継承したクラス。
 * 定数を定義するためにinit.phpが必要。
 */

require_once "./init.php";
require_once "./BaseModel.php";

class PDODatabase extends BaseModel{

    private  $db_host = "";
    private  $db_user = "";
    private  $db_pass = "";
    private  $db_name = "";
    private  $db_type = "";

    private  $order   = '';
    private  $limit   = '';
    private  $offset  = '';
    private  $groupby = '';

//    public function __construct( $db_host, $db_user, $db_pass, $db_name, $db_type )
//    {
//        $this->PDO     = $this->connect( $db_host, $db_user, $db_pass, $db_name, $db_type );
//        $this->db_host = $db_host;
//        $this->db_user = $db_user;
//        $this->db_pass = $db_pass;
//        $this->db_name = $db_name;
//
//        //SQL関連
//        $this->order   = '';
//        $this->limit   = '';
//        $this->offset  = '';
//        $this->groupby = '';
//    }

//    private function connect( $db_host, $db_user, $db_pass, $db_name, $db_type)
//    {
//
//        try{
//            switch( $db_type )
//            {
//                case 'mysql':
//                    $dsn = 'mysql:host='.$db_host.';dbname='.$db_name;
//                    $dbh = new PDO($dsn,$db_user,$db_pass);
//                    $dbh->query('SET NAMES utf8');
//                    break;
//
//                case 'pgsql':
//                    $dsn = 'pgsql:dbname='.$db_name.' host=' . $db_host .' port=5432';
//                    $dbh = new PDO($dsn,$db_user,$db_pass);
//                    break;
//            }
//        }
//        catch(PDOException $e)
//        {
//            var_dump($e->getMessage());
//            exit;
//        }
//
//        return $dbh;
//    }

    public function setQuery( $query='', $arrVal = array() )
    {
        $stmt = $this->PDO->prepare($query);
        $stmt->execute($arrVal);

    }


    public function select( $table, $column ='',$where = '', $arrVal = array())
    {
        $sql = $this->getSql( 'select', $table, $where, $column);

        $stmt = $this->PDO->prepare($sql);
        $stmt->execute($arrVal);

        //データを連想配列に格納
        $data = array();
        while($result = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            array_push($data , $result);
        }


        return $data;
    }

    public function count( $table, $where='', $arrVal=array())
    {
        $sql = $this->getSql('count',$table, $where );
        $stmt = $this->PDO->prepare($sql);

        $stmt->execute($arrVal);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return intval($result['NUM']);
    }

    public function setOrder( $order ='' )
    {
        if( $strOrder !== '' ) $this->order = ' OREDER BY ' . $strOrder;
    }

    public function setLimitOff( $limit ='', $offset ='' )
    {
        if( $limit !== "" )  $this->limit = " LIMIT " . $limit ;

        if( $offset !== "" )  $this->offset = " OFFSET ". $offset ;

    }

    public function setGroupBy( $groupby )
    {
        if( $groupby !== "" ) $this->groupby = ' GROUP BY ' . $groupby;
    }


    private function getSql( $type,$table,$where='',$column='')
    {

        switch( $type )
        {
            case 'select':
                $columnKey =( $column !=='') ? $column : "*" ;
                break;

            case 'count':
                $columnKey = 'COUNT(*) AS NUM ';
                break;

            default:
                break;
        }

        $whereSQL = ( $where !== '' )?' WHERE  ' . $where :'';

        $other = $this->groupby . "  " . $this->order ."  " . $this->limit . "  " . $this->offset;

        //sql文の作成
        $sql = " SELECT "
            .      $columnKey
            . " FROM "
            .      $table
            .      $whereSQL
            .      $other;

        return $sql;
    }


    public function insert($table, $insData=array() )
    {

        list( $preSt, $insDataVal, $columns) = $this->getPreparedStatement( 'insert', $insData, $table );

        $sql = " INSERT INTO " . $table . " ("
            .      $columns
            . ") VALUES ("
            .      $preSt
            . ") " ;

        $stmt = $this->PDO->prepare( $sql );
        $res  = $stmt->execute($insDataVal);

        return $res;
    }

    public function update($table ,$insData = array() ,$where, $arrWhereVal=array())
    {
        list( $preSt, $insDataVal) = $this->getPreparedStatement( 'update', $insData, $table );

        //sql文の作成
        $sql = " UPDATE "
            .      $table
            . " SET "
            .      $preSt
            . " WHERE "
            .      $where ;

        $updateData = array_merge($insDataVal,$arrWhereVal);
        $stmt       = $this->PDO->prepare( $sql );
        $res        = $stmt->execute($updateData);

        return $res ;
    }

    public function getPreparedStatement( $mode, $insData, $table )
    {

        if( !empty($insData) )
        {

            $insDataKey = array_keys($insData);
            $insDataVal = array_values($insData);
            $preCnt     = count( $insDataKey );

            switch( $mode )
            {
                case 'insert':

                    $columns  = implode(",",$insDataKey);
                    $arrPreSt = array_fill( 0, $preCnt,'?');
                    $preSt    = implode(",",$arrPreSt);

                    return array($preSt, $insDataVal, $columns);

                    break;

                case 'update':

                    for( $i=0;$i < $preCnt; $i++ )
                    {
                        $arrPreSt[$i] = $insDataKey[$i] ." =? ";
                    }

                    $preSt =implode(",",$arrPreSt);

                    return array($preSt, $insDataVal);

                    break;
            }

        }
        else
        {
            return false;
        }

    }

    public function getLastId()
    {
        return $this->PDO->lastInsertId();
    }
}
