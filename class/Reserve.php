<?php

class Reserve {
    private $UID            = 0;
    private $RID            = 0;
    private $SID            = 0;
    private $startDay       = "0000-00-00";                 //String(Date)  2016-05-06
    private $startTime      = "00:00:00";                   //String(Time)  14:05
    private $reservedTime   = "0000-00-00 00:00:00";        //String(Timestamp)  2016-05-09 14:05:21
    private $peopleNum      = 0;                            //int
    private $course         = 0;                            //int
    private $course_flag    = false;                        //boolean - default false
    private $course_4       = array();                      //Array(" ", " ", " ", " ")
    private $err            = array();                      //Array()

    public function getUID() {
        return $this->UID;
    }
    public function setUID($UID) {
        if(preg_match( '/[0-9]+/', $UID ))
            $this->UID = $UID;
        else $this->err[] = "UIDがおかしいです。";
    }
    public function getRID() {
        return $this->RID;
    }
    public function setRID($RID) {
        if(preg_match( '/[0-9]+/', $RID ))
            $this->RID = $RID;
    }
    public function getSID() {
        return $this->SID;
    }
    public function setSID($SID) {
        if( $SID > 0 )  // データベースにデータを入力する前はないです
            $this->SID = $SID;
    }
    public function getStartDay() {
		return $this->startDay;
	}
	public function setStartDay($startDay) {

        $parseDate = explode("-", $startDay);

        if(preg_match( '/([2-9]{1}[0-9]{3})/', $parseDate[0] ) &&
            checkdate( $parseDate[1], $parseDate[2], $parseDate[0] )) {

            $this->startDay = $startDay;
        } else $this->err[] = "StartDayのタイプが間違いました。";
    }
    public function getStartTime() {
        return $this->startTime;
    }
    public function setStartTime($startTime) {
        if(preg_match( '/([0-9]{2}):([0-9]{2}):([0-9]{2})/', $startTime )) {
            $this->startTime = $startTime;
        } else $this->err[] = "startTimeのタイプが間違いました。";
    }
    public function getReservedTime() {
        return $this->reservedTime;
    }
    public function setReservedTime($reservedTime) {

        $parseTimeStamp = explode(" ", $reservedTime);      //2016-05-09と14:00:00をわけ
        $parseDate      = explode("-", $parseTimeStamp[0]); //2016-05-09を-ことにわけ

        if(preg_match( '/([2-9]{1}[0-9]{3})/', $parseDate[0] ) &&
            checkdate( $parseDate[1], $parseDate[2], $parseDate[0] ) ) {

            if(preg_match( '/([0-9]{2}):([0-9]{2}):([0-9]{2})/', $parseTimeStamp[1] )) {
                $this->reservedTime = $reservedTime;
            }

        } else $this->err[] = "ReservedTimeが間違いました。";
    }
    public function getPeopleNum() {
        return $this->peopleNum;
    }
    public function setPeopleNum($peopleNum) {
        if( $peopleNum > 0 && $peopleNum <= 30 ) {
            $this->peopleNum = $peopleNum;
        } else $this->err[] = "peopleNumが間違いました。1~30までです。";
    }
    public function getCourse() {
        return $this->course;
    }
    public function setCourse($course) {
        if($course == 4 || $course == 7 || $course == 10) {
            $this->course = $course;
        } else $this->err[] = "4，7，10だけです。";
    }
    public function getCourse_flag() {
        return $this->course_flag;
    }
    public function setCourse_flag($course_flag) {
        if($course_flag === true || $course_flag === false)
            $this->course_flag = $course_flag;
        else $this->err[] = "COURSE_FLAGのタイプが間違いました。";
    }
    public function getCourse_4() {             // Array型
        return $this->course_4;
    }
    public function setCourse_4($course_4) {    // Array型
        if( count($course_4) == 4 ) {
            $this->course_4 = $course_4;
        } else $this->err[] = "4個までです。";
    }

    public function errCheck() {
        return $this->err;
    }
}
?>