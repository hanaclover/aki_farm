<?php

/*
 * class ReserveModel
 * made by meijin
 * data : 20160509
 * 予約関連のデータベースを扱うクラス
 *
 */

require_once "./PDODatabase.class.php";

class ReserveModel {
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
        $insData = array(
            "UID" => $res->getUID(),
            "SID" => $res->getSID(),
            "StartDay" => $res->getStartDay(),
            "StartTime" => $res->getStartTime(),
            "ReservedTime" => $res->getReservedTime(),
            "PeopleNum" => $res->getPeopleNum(),
            "Course" => $res->getCourse(),
            "Course_Flag" => $res->getCourse_flag(),
            "Course_4" => $res->getCourse_4()
        );
//        もしかしてSIDってここで計算しなければいけない・・・?
//        はいはい、わかりましたよ!
        $sm = new SeatModel();
        $seatArray = $sm->getSeat($res->getPeopleNum());
        foreach ($seatArray as $value){
            $flag = false;
            $snum = $value;
//            予約テーブルの中で座席の予約を検索して
//            その予約があれば、時間が2時間以内かを調べる
//            もし2時間以内ならアウト。次の座席へ
//            最後までセーフならインサートしてリターンしてしまう
            $arrRes = array($snum);
            $seatSel = $pdo->select("reserve" , "" ,
                "sNum=?" , $arrRes);
            foreach ($seatSel as $value) {
                if ($res->getStartDay() == $seatSel["StartDay"]){
                    if ($res->getStartTime() + 7200 >= $seatSel["StartTime"]
                    && $res->getStartTime() <= $seatSel["StartTime"]){
                        $flag = true;
                    }
                }
            }
            if(!$flag) {
                $pdo->insert("reserve", $insData);
                return true;
            }
        }
        return false;
    }
    private function isEmpty( $seatNum ){
//        座席番号を受け取ったら、今この時間に空いているか検索する
//        １．まずは現在時刻を求める
//        ２．次にSQL文を発行する。内容は「座席番号が一致かつ現在時刻±2時間以内の予約」
//        ３．発行した結果が空かどうかをReturnする
        $today = date("y-m-d");
        $nowTime = time();
        $pdo = new PDODatabase();
        $arrSeat = array($seatNum);
        $seatID = $pdo->select("seat" , "SID" , "seatNum=?" , $arrSeat);
        $sid = $seatID[0];
        $arrRes = array($sid , $today );
        $res = $pdo->select("reserve" , "" ,
            "SID=? and StartDay=?" , $arrRes);
        foreach ($res as $key => $value){
            $startTime = strtotime($value["StartDay"]." ".$value["StartTime"]);
            if ($startTime > ($nowTime - 7200) && $nowTime >= $startTime){
                return false;
            }
        }
        return true;
    }
    private function nextReserveTime( $seatNum ){
//        次の予約時刻を返す
//        この日に予約が入っていなかったら０を返す
        $today = date("y-m-d");
        $nowTime = time();
        $pdo = new PDODatabase();
        $arrSeat = array($seatNum);
        $seatID = $pdo->select("seat" , "SID" , "seatNum=?" , $arrSeat);
        $sid = $seatID[0];
        $arrRes = array($sid , $today );
        $res = $pdo->select("reserve" , "" ,
            "SID=? and StartDay=?" , $arrRes);
        $startTime = 0;
        foreach ($res as $key => $value){
            $st = strtotime($value["StartDay"]." ".$value["StartTime"]);
            if ($startTime == 0 || $startTime > $st){
                $startTime = $st;
            }
        }
        return $startTime;
    }
    private function endTime( $seatNum ){
        $today = date("y-m-d");
        $nowTime = time();
        $pdo = new PDODatabase();
        $arrSeat = array($seatNum);
        $seatID = $pdo->select("seat" , "SID" , "seatNum=?" , $arrSeat);
        $sid = $seatID[0];
        $arrRes = array($sid , $today );
        $res = $pdo->select("reserve" , "" ,
            "SID=? and StartDay=?" , $arrRes);
        foreach ($res as $key => $value){
            $startTime = strtotime($value["StartDay"]." ".$value["StartTime"]);
            if ($startTime >= $nowTime && $nowTime >= ($startTime - 7200)){
                return $startTime;
            }
        }
        return 0;
    }
    public function getReserve( $seatNum ){
        if ($this->isEmpty($seatNum)){
            return "予約可能";
        }else{
            if ($this->nextReserveTime($seatNum) != 0){
                return date("hh:mm",$this->nextReserveTime($seatNum));
            }else{
                return date("hh:mm",$this->endTime($seatNum));
            }
        }
        return "";
    }
    public function getTodayReserves(){
        $today = date("y-m-d");
        $pdo = new PDODatabase();
        $arrRes = array($today);
        $res = $pdo->select("reserve" , "" ,
            "StartDay=?" , $arrRes);
        return $res;
    }
    public function changeReserve( $id , $res ){
        $this->deleteReserve($id);
        $this->setReserve($res);
    }
    public function deleteReserve( $id ){
        $pdo = new PDODatabase();
        $pdo->update("reserve" , array("2000-01-01") , "RID=?" , array($id));
    }
    public function getReservesByDate( $day ){
        $pdo = new PDODatabase();
        $arrRes = array($day);
        $res = $pdo->select("reserve" , "" ,
            "StartDay=?" , $arrRes);
        return $res;
    }
    public function isAbleUserReserve( Reserve $res ){
//        座席番号かNULLを返す
        $day = $res->getStartDay();
        $nowTime = $res->getStartTime();
        $pdo = new PDODatabase();
        $arrRes = array($day);
        $res = $pdo->select("reserve" , "" ,
            "StartDay=?" , $arrRes);
        foreach ($res as $key => $value){
            $startTime = strtotime($value["StartDay"]." ".$value["StartTime"]);
            if ($startTime > ($nowTime - 7200) && $nowTime >= $startTime){
                return false;
            }
        }
        return true;
    }
}