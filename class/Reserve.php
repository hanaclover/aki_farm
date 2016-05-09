<?php

class Reserve {
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
        if(preg_match( '/([0-9]{2})-([0-9]{2})-([0-9]{2})/', $startDay ) === 0 ) {
            $this->startDay = $startDay;
        } else {
            echo "おかしいです";
        }
    }
    public function getStartTime() {
        return $this->startTime;
    }
    public function setStartTime($startTime) {
        $this->startTime = $startTime;
    }
    public function getReservedTime() {
        return $this->reservedTime;
    }
    public function setReservedTime($reservedTime) {
        $this->reservedTime = $reservedTime;
    }
    public function getPeopleNum() {
        return $this->peopleNum;
    }
    public function setPeopleNum($peopleNum) {
        $this->peopleNum = $peopleNum;
    }
    public function getCourse() {
        return $this->course;
    }
    public function setCourse($course) {
        $this->course = $course;
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