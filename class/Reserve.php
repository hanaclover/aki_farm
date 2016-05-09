<?php

class Reserve {
    private $starDay        = "";       //String(Date)
    private $startTime      = "";       //String(Time)
    private $reservedTime   = "";       //String(Time)
    private $peopleNum      = 0;        //int
    private $course         = 0;        //int okasii
    private $course_flag    = false;    //boolean
    private $course_4       = "";       //String

    public function getStarDay() {
		return $this->starDay;
	}
	public function setStarDay($starDay) {
        $this->starDay = $starDay;
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