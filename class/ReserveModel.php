<?php

/*
 * class ReserveModel
 * made by meijin
 * data : 20160509
 * 予約関連のデータベースを扱うクラス
 */

//まだテストされていないのでチェックが必要
//正しく動いたと判断したメソッドには○を付けます

//コンストラクタを創ってReseerveを渡すようにするのもアリ!

require_once "./class/PDODatabase.class.php";
require_once "./class/SeatModel.php";

function echoman($echoStr){
    echo "<pre>";
    var_dump($echoStr);
    echo "</pre>";
}

class ReserveModel {

    //const DISTANCETIME = 3600*7;
    const DISTANCETIME = 25200;
    //const DINNERLENGTH = 60 * 60 * 2;
    const DINNERLENGTH = 7200;
    private $minJoinTableNum = 100; //100
    private $arrJoinTableNum = array(7 , 8 , 9); //array(5,6)

    public function __construct()
    {
//        date_default_timezone_set("Asia/Tokyo");
    }

    public function confirmReserve(Reserve $res){
//        もしかしてSIDってここで計算しなければいけない・・・?
//        はいはい、わかりましたよ!
        $seatPDO = new PDODatabase();
        $sm = new SeatModel($seatPDO);

        $this->minJoinTableNum = $sm->getJointTableStartNum();
        $this->arrJoinTableNum = $sm->getJointTableSID();

        $selPDO = new PDODatabase();
        $snum = 0;
        $seatArray = $sm->getSeat($res->getPeopleNum());
        foreach ($seatArray as $value){
            $snum = $value;
            if ($snum >= $this->minJoinTableNum){

//                ここが現在、部屋数3に依存するコードだから
//                修正したい。どうするか?

                $rooms = array();
                if (count($this->arrJoinTableNum)==3)
                    switch ($snum){
                        case $this->minJoinTableNum+2:
                            $rooms[] = $this->arrJoinTableNum[0];
                            $rooms[] = $this->arrJoinTableNum[1];
                            $rooms[] = $this->arrJoinTableNum[2];
                            break;
                        case $this->minJoinTableNum+1:
                            $rooms[] = $this->arrJoinTableNum[1];
                            $rooms[] = $this->arrJoinTableNum[2];
                            break;
                        case $this->minJoinTableNum:
                            $rooms[] = $this->arrJoinTableNum[0];
                            $rooms[] = $this->arrJoinTableNum[1];
                            break;
                    }
                else if (count($this->arrJoinTableNum)==2){

                    //snumは関係ないよねー

                    $rooms[] = $this->arrJoinTableNum[0];
                    $rooms[] = $this->arrJoinTableNum[1];
                }
                $flag = false;
                $outFlag = false;
                foreach ($rooms as $arr) {
//            予約テーブルの中で座席の予約を検索して
//            その予約があれば、時間が2時間以内かを調べる
//            もし2時間以内ならアウト。次の座席へ
//            最後までセーフならインサートしてリターンしてしまう
                    $arrRes = array($arr, 0);
//            ある座席の予約一覧
                    $seatSel = $selPDO->select("reserve", "",
                        "SID=? and del_flag=?", $arrRes);
//                    echoman($rooms);
                    foreach ($seatSel as $value) {
                        if ($res->getStartDay() == $value["StartDay"]) {
                            if (strtotime($res->getStartTime()) > strtotime($value["StartTime"]) - self::DINNERLENGTH
                                && strtotime($res->getStartTime()) < strtotime($value["StartTime"]) + self::DINNERLENGTH
                            ) {
                                $outFlag = true;
                                break;
                            }
                        }
                    }
                }
                if (!$outFlag) {
                    $flag = true;
                    break;
                }
            }else {
                $flag = false;
                $outFlag = false;
//            予約テーブルの中で座席の予約を検索して
//            その予約があれば、時間が2時間以内かを調べる
//            もし2時間以内ならアウト。次の座席へ
//            最後までセーフならインサートしてリターンしてしまう
                $arrRes = array($snum,0);
//            ある座席の予約一覧
                $seatSel = $selPDO->select("reserve", "",
                    "SID=? and del_flag=?", $arrRes);
                foreach ($seatSel as $value) {
                    if ($res->getStartDay() == $value["StartDay"]) {
                        if (strtotime($res->getStartTime()) > strtotime($value["StartTime"]) - self::DINNERLENGTH
                            && strtotime($res->getStartTime()) < strtotime($value["StartTime"]) + self::DINNERLENGTH
                        ) {
                            $outFlag = true;
                            break;
                        }
                    }
                }
                if (!$outFlag) {
                    $flag = true;
                    break;
                }
            }
        }
//        echo "$snum<br>";
        return $flag ? $snum : 0;
    }
    public function setReserve(Reserve $res){
//      このメソッドはReserveクラスのインスタンスが渡されると
//      PDOクラスを使ってデータベースに挿入する
//        private $startDay        = "";       //String(Date)
//        private $startTime      = "";       //String(Time)
//        private $reservedTime   = "";       //String(Time)
//        private $peopleNum      = 0;        //int
//        private $course         = 0;        //int
//        private $course_flag    = false;    //boolean
//        private $course_4       = "";       //String
        $pdo = new PDODatabase();
        $snum = $res->getSID();
        $insData = array(
            "UID" => $res->getUID(),
            "SID" => $res->getSID(),
            "StartDay" => $res->getStartDay(),
            "StartTime" => $res->getStartTime(),
            "PeopleNum" => $res->getPeopleNum(),
            "Course" => $res->getCourse(),
            "Course_Flag" => var_export($res->getCourse_flag(),TRUE),
            "Course_4" => implode($res->getCourse_4()),
            "join_flag" => 0
        );
        if ($snum != 0) {
            $insData["SID"] = $snum;
        }
        switch ($snum){
            case $this->minJoinTableNum+2:
                $insData["join_flag"] = 1;
                $insData["SID"] = (string)$this->arrJoinTableNum[2];
                $pdo->insert("reserve", $insData);
                $insData["SID"] = (string)$this->arrJoinTableNum[1];
                $pdo->insert("reserve", $insData);
                $insData["SID"] = (string)$this->arrJoinTableNum[0];
                break;
            case $this->minJoinTableNum+1:
                $insData["join_flag"] = 1;
                $insData["SID"] = (string)$this->arrJoinTableNum[2];
                $pdo->insert("reserve", $insData);
                $insData["SID"] = (string)$this->arrJoinTableNum[1];
                break;
            case $this->minJoinTableNum:
                $insData["join_flag"] = 1;
                $insData["SID"] = (string)$this->arrJoinTableNum[1];
                $pdo->insert("reserve", $insData);
                $insData["SID"] = (string)$this->arrJoinTableNum[0];
                break;
            default: break;
        }
        $pdo->insert("reserve", $insData);
        return true;
    }
    private function isEmpty( $seatNum ){
//        座席番号を受け取ったら、今この時間に予約できるか検索する
//        １．まずは現在時刻を求める
//        ２．次にSQL文を発行する。内容は「座席番号が一致かつ現在時刻±2時間以内の予約」
//        ３．発行した結果が空かどうかをReturnする
        $today = date("Y-m-d");
        $nowTime = time()+self::DISTANCETIME;
        $pdo = new PDODatabase();
        $arrSeat = array($seatNum);
        $seatID = $pdo->select("seat" , "SID" , "sNum=?" , $arrSeat);
        $sid = $seatID[0]["SID"];
        $arrRes = array($sid , $today ,"0");
        $res = $pdo->select("reserve" , "" ,
            "SID=? and StartDay=? and del_flag=?" , $arrRes);
        foreach ($res as $key => $value){
            $startTime = strtotime($value["StartDay"]." ".$value["StartTime"]);
            if ($startTime > ($nowTime - self::DINNERLENGTH ) && $nowTime + self::DINNERLENGTH >= $startTime){
                //echo "<br>$seatNum : ";
                return false;
            }
        }
        return true;
    }
    private function nextReserveTime( $seatNum ){
        //今埋まってないけど、2時間以内に予約が入っている場合に、それが空く時刻
//        次の予約時刻を返す
//        この日に予約が入っていなかったら０を返す
        $today = date("y-m-d");
        $nowTime = time()+self::DISTANCETIME;
        $pdo = new PDODatabase();
        $arrSeat = array($seatNum);
        $seatID = $pdo->select("seat" , "SID" , "sNum=?" , $arrSeat);
        $sid = $seatID[0]["SID"];
        $arrRes = array($sid , $today , 0);
        $res = $pdo->select("reserve" , "" ,
            "SID=? and StartDay=? and del_flag=?" , $arrRes);
        $startTime = 0;
        foreach ($res as $key => $value){
            $st = strtotime($value["StartDay"]." ".$value["StartTime"]);
            if ($startTime == 0 || $startTime > $st){
                if ($nowTime < $st)
                    $startTime = $st+self::DINNERLENGTH;
            }
        }
        return $startTime;
    }
    private function endTime( $seatNum ){
//        今現在すでに入っている予約が終わる時間を返す
        $today = date("y-m-d");
        $nowTime = time()+self::DISTANCETIME;
        $pdo = new PDODatabase();
        $arrSeat = array($seatNum);
        $seatID = $pdo->select("seat" , "SID" , "sNum=?" , $arrSeat);
        $sid = $seatID[0]["SID"];
        $arrRes = array($sid , $today , 0);
        $res = $pdo->select("reserve" , "" ,
            "SID=? and StartDay=? and del_flag=?" , $arrRes);
        foreach ($res as $key => $value){
            $startTime = strtotime($value["StartDay"]." ".$value["StartTime"]);
//            echo "start:";
//            var_dump(date("Y-m-d H:i:s",$startTime));
//            echo "<br>now:";
//            var_dump(date("Y-m-d H:i:s",$nowTime));
//            echo "<br>";
            if ($startTime <= $nowTime && $nowTime <= ($startTime + self::DINNERLENGTH)){
                return $startTime+self::DINNERLENGTH;
            }
        }
        return 0;
    }
    public function getReserve( $seatNum ){
        // 空席状況の確認
            // 空席の場合
        if ($this->isEmpty($seatNum)){ //$this->isEmpty($seatNum)
            return "予約可能";
        }else{ // 予約有りの場合
            // 現在は空席だが２時間以内に予約が有る場合、
            // 次の予約のスタート時間を返す
            if ($this->nextReserveTime($seatNum) != 0){
                
                $res = array(
                    "flag"   => 0,
                    "msg"    =>  "次の予約時間：".date("H:i:s",$this->nextReserveTime($seatNum)));
                return $res;
            }elseif ($this->endTime($seatNum) != 0){ // 現在使用中の場合、終了時間を返す。
                $res = array(
                    "flag"  => 1,
                    "msg"   => "終了時間 :".date("H:i:s",$this->endTime($seatNum)));
            }else{
                return "空席";
            }
        }
        return "予約なし";
    }
    public function getTodayReserves(){
        //今日の予約情報一覧をユーザー情報と関連付けて返す関数
//        MariaDB [aki_farm_db]> SELECT rid,snum,startday,starttime,peoplenum,familyname,c
//ourse,course_4,phonenum FROM reserve inner join user on reserve.uid=user.uid inn
//er join seat on reserve.sid=seat.sid WHERE  StartDay="2016-05-12" and del_Flag=0
//        ;
        $today = date("y-m-d");
        $pdo = new PDODatabase();
        $arrRes = array($today,"0");
        $res = $pdo->select("reserve inner join user on reserve.uid=user.uid "
         ."inner join seat on reserve.sid=seat.sid"
            , "rid,snum,startday,starttime,peoplenum,familyname,course,course_4,phonenum" ,
            "StartDay=? and del_flag=?" , $arrRes);
        return $res;
    }
    public function changeReserve( $id , $res ){
        $this->deleteReserve($id);
        $this->setReserve($res);
    }
    public function deleteReserve( $id ){
//        ここをDel_flagを反映させるように変更する
//        $table = ' cart ';
//        $insData = array( 'delete_flg'=> 1 );
//        $where =' crt_id = ? ';
//        $arrWhereVal = array( $crt_id );
//        return $this->db->update( $table, $insData, $where, $arrWhereVal);

//        くっつけている部屋の場合はどうする!?
//        if join_flag=1 then we must delete other join_flag=1 column.

        $pdo = new PDODatabase();
        $joinNum = 0;
        $sel = $pdo->select("reserve" , "" , "rid=?" , array($id));
        $time = "";
        foreach ($sel as $value){
            if ($value["join_flag"]=="1"){
                $joinNum = 1;
                $time = $value["StartTime"];
            }
        }
        $pdo->update("reserve" , array('del_flag' => 1)
            , "join_flag=? and starttime=?" , array($joinNum,$time));
    }
    public function getReservesByDate( $day ){
        $pdo = new PDODatabase();
        $arrRes = array($day,"0");
        $res = $pdo->select("reserve" , "" ,
            "StartDay=? and del_flag=?" , $arrRes);
        return $res;
    }
    public function isAbleUserReserve( Reserve $res ){
//        座席番号かNULLを返す
        $day = $res->getStartDay();
        $nowTime = $res->getStarttime()+self::DISTANCETIME;
        $pdo = new PDODatabase();
        $arrRes = array($day,"0");
        $res = $pdo->select("reserve" , "" ,
            "StartDay=? and del_flag=?" , $arrRes);
        foreach ($res as $key => $value){
            $startTime = strtotime($value["StartDay"]." ".$value["StartTime"]);
            if ($startTime > ($nowTime - self::DINNERLENGTH) && $nowTime >= $startTime){
                return false;
            }
        }
        return true;
    }
}
