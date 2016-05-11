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

class ReserveModel {
    public function confirmReserve(Reserve $res){
//        もしかしてSIDってここで計算しなければいけない・・・?
//        はいはい、わかりましたよ!
        $pdo = new PDODatabase();
        $sm = new SeatModel($pdo);
        $snum = 0;
        $seatArray = $sm->getSeat($res->getPeopleNum());
        foreach ($seatArray as $value){
            $snum = $value;
            if ($snum > 18){
                $rooms = array();
                switch ($snum){
                    case 21:
                        $rooms[] = 7;
                        $rooms[] = 8;
                        $rooms[] = 9;
                        break;
                    case 20:
                        $rooms[] = 8;
                        $rooms[] = 9;
                        break;
                    case 19:
                        $rooms[] = 7;
                        $rooms[] = 8;
                        break;
                }
                $flag = false;
                $outFlag = false;
                foreach ($rooms as $val){
//            予約テーブルの中で座席の予約を検索して
//            その予約があれば、時間が2時間以内かを調べる
//            もし2時間以内ならアウト。次の座席へ
//            最後までセーフならインサートしてリターンしてしまう
                    $arrRes = array($val);
//            ある座席の予約一覧
                    $seatSel = $pdo->select("reserve", "",
                        "SID=?", $arrRes);
                    foreach ($seatSel as $value) {
                        if ($res->getStartDay() == $value["StartDay"]) {
                            if (strtotime($res->getStartTime()) > strtotime($value["StartTime"]) - 7200
                                && strtotime($res->getStartTime()) < strtotime($value["StartTime"]) + 7200
                            ) {
                                $outFlag = true;
                                break;
                            }
                        }
                    }
                }
            }else {
                $flag = false;
                $outFlag = false;
//            予約テーブルの中で座席の予約を検索して
//            その予約があれば、時間が2時間以内かを調べる
//            もし2時間以内ならアウト。次の座席へ
//            最後までセーフならインサートしてリターンしてしまう
                $arrRes = array($snum);
//            ある座席の予約一覧
                $seatSel = $pdo->select("reserve", "",
                    "SID=?", $arrRes);
                foreach ($seatSel as $value) {
                    if ($res->getStartDay() == $value["StartDay"]) {
                        if (strtotime($res->getStartTime()) > strtotime($value["StartTime"]) - 7200
                            && strtotime($res->getStartTime()) < strtotime($value["StartTime"]) + 7200
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
            "Course_4" => implode($res->getCourse_4())
        );
        if ($snum != 0) {
            $insData["SID"] = $snum;
        }
        switch ($snum){
            case 21:
                $insData["SID"] = "9";
                $pdo->insert("reserve", $insData);
                $insData["SID"] = "8";
                $pdo->insert("reserve", $insData);
                $insData["SID"] = "7";
                break;
            case 20:
                $insData["SID"] = "9";
                $pdo->insert("reserve", $insData);
                $insData["SID"] = "8";
                break;
            case 19:
                $insData["SID"] = "8";
                $pdo->insert("reserve", $insData);
                $insData["SID"] = "7";
                break;
            default: break;
        }
        $pdo->insert("reserve", $insData);
        return true;
    }
    private function isEmpty( $seatNum ){
//        座席番号を受け取ったら、今この時間に空いているか検索する
//        １．まずは現在時刻を求める
//        ２．次にSQL文を発行する。内容は「座席番号が一致かつ現在時刻±2時間以内の予約」
//        ３．発行した結果が空かどうかをReturnする
        $today = date("Y-m-d");
        $nowTime = time()+3600*7;
        $pdo = new PDODatabase();
        $arrSeat = array($seatNum);
        $seatID = $pdo->select("seat" , "SID" , "sNum=?" , $arrSeat);
        $sid = $seatID[0]["SID"];
        $arrRes = array($sid , $today );
        $res = $pdo->select("reserve" , "" ,
            "SID=? and StartDay=?" , $arrRes);
        foreach ($res as $key => $value){
            $startTime = strtotime($value["StartDay"]." ".$value["StartTime"]);
            if ($startTime > ($nowTime - 7200 ) && $nowTime + 7200 >= $startTime){
                echo "<br>$seatNum : ";
                return false;
            }
        }
        return true;
    }
    private function nextReserveTime( $seatNum ){
//        次の予約時刻を返す
//        この日に予約が入っていなかったら０を返す
        $today = date("y-m-d");
        $nowTime = time()+3600*7;
        $pdo = new PDODatabase();
        $arrSeat = array($seatNum);
        $seatID = $pdo->select("seat" , "SID" , "sNum=?" , $arrSeat);
        $sid = $seatID[0]["SID"];
        $arrRes = array($sid , $today );
        $res = $pdo->select("reserve" , "" ,
            "SID=? and StartDay=?" , $arrRes);
        $startTime = 0;
        foreach ($res as $key => $value){
            $st = strtotime($value["StartDay"]." ".$value["StartTime"]);
            if ($startTime == 0 || $startTime > $st){
                if ($nowTime < $st)
                    $startTime = $st+7200;
            }
        }
        return $startTime;
    }
    private function endTime( $seatNum ){
        $today = date("y-m-d");
        $nowTime = time()+3600*7;
        $pdo = new PDODatabase();
        $arrSeat = array($seatNum);
        $seatID = $pdo->select("seat" , "SID" , "sNum=?" , $arrSeat);
        $sid = $seatID[0]["SID"];
        $arrRes = array($sid , $today );
        $res = $pdo->select("reserve" , "" ,
            "SID=? and StartDay=?" , $arrRes);
        foreach ($res as $key => $value){
            $startTime = strtotime($value["StartDay"]." ".$value["StartTime"]);
//            echo "start:";
//            var_dump(date("Y-m-d H:i:s",$startTime));
//            echo "<br>now:";
//            var_dump(date("Y-m-d H:i:s",$nowTime));
//            echo "<br>";
            if ($startTime <= $nowTime && $nowTime <= ($startTime + 7200)){
                return $startTime+7200;
            }
        }
        return 0;
    }
    public function getReserve( $seatNum ){
        if ($this->isEmpty($seatNum)){ //$this->isEmpty($seatNum)
            return "$seatNum : 空席";
        }else{
            if ($this->nextReserveTime($seatNum) != 0){
                return "$seatNum : next->".date("H:i:s",$this->nextReserveTime($seatNum));
            }elseif ($this->endTime($seatNum) != 0){
                return "$seatNum : end ->".date("H:i:s",$this->endTime($seatNum));
            }else{
                return "空席";
            }
        }
        return "予約なし";
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
        $nowTime = $res->getStarttime()+3600*7;
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