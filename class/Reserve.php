<?php

class Reserve {
    private $UID            = "";
    private $RID            = "";
    private $SID            = "";
    private $startDay       = "";       //String(Date)  2016-05-06
    private $startTime      = "";       //String(Time)  14:05
    private $reservedTime   = "";       //String(Timestamp)  2016-05-09 14:05:21
    private $peopleNum      = 0;        //int
    private $course         = 0;        //int
    private $course_flag    = false;    //boolean
    private $course_4       = "";       //String(Array)

    public function getStartDay() {
		return $this->startDay;
	}
	public function setStartDay($startDay) {

        $parseDate = explode("-", $startDay);

        if(preg_match( '/([2-9]{1}[0-9]{3})/', $startDay ) === 0 &&
            checkdate( $parseDate[1], $parseDate[2], $parseDate[0] ) === false ) {

            $this->startDay = $startDay;
        } else echo "StartDayのタイプが間違いました。";
    }

    public function getStartTime() {
        return $this->startTime;
    }
    public function setStartTime($startTime) {
        if(preg_match( '/([0-9]{2}):([0-9]{2}):([0-9]{2})/', $startTime ) === 0 ) {
            $this->startTime = $startTime;
        } else echo "startTimeのタイプが間違いました。";
    }
    public function getReservedTime() {
        return $this->reservedTime;
    }
    public function setReservedTime($reservedTime) {

        $parseTimeStamp = explode(" ", $reservedTime);      //2016-05-09と14:00:00をわけ
        $parseDate      = explode("-", $parseTimeStamp[0]); //2016-05-09を-ことにわけ

        if(preg_match( '/([2-9]{1}[0-9]{3})/', $parseDate[0] ) === 0 &&
            checkdate( $parseDate[1], $parseDate[2], $parseDate[0] ) === false ) {

            echo "ReservedTimeの年度が間違いました。";

            if(preg_match( '/([0-9]{2}):([0-9]{2}):([0-9]{2})/', $parseTimeStamp[1] ) === 0 ) {
                $this->reservedTime = $reservedTime;
            }

        } else echo "ReservedTimeが間違いました。";

    }
    public function getPeopleNum() {
        return $this->peopleNum;
    }
    public function setPeopleNum($peopleNum) {
        if(preg_match( '/([1-9]{1})([0-9]{1})/', $peopleNum ) === 0 ) {
            $this->peopleNum = $peopleNum;
        } else echo "peopleNumが間違いました。1~30までです。";
    }
    public function getCourse() {
        return $this->course;
    }
    public function setCourse($course) {
        if($course == 4 || $course == 7 || $course == 10) {
            $this->course = $course;
        }
    }
    public function getCourse_flag() {
        return $this->course_flag;
    }
    public function setCourse_flag($course_flag) {
        $this->course_flag = $course_flag;
    }
    public function getCourse_4() {
        return $this->course_4;
    }
    public function setCourse_4($course_4) {
        $this->course_4 = $course_4;
    }
}

?>