<?php
class Reserved {
    private $starDay        = "";   //Date
    private $startTime      = "";   //Date(Time)
    private $course         = 0;    //int
    private $peopleNum      = 0;    //int
    private $course_4       = "";   //String
    private $reservedTime   = "";   //Date(Time)

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
    public function getCourse() {
        return $this->course;
    }
    public function setCourse($course) {
        $this->course = $course;
    }
    public function getPeopleNum() {
        return $this->peopleNum;
    }
    public function setPeopleNum($peopleNum) {
        $this->peopleNum = $peopleNum;
    }
    public function getCourse_4() {
        return $this->course_4;
    }
    public function setCourse_4($course_4) {
        $this->course_4 = $course_4;
    }
    public function getReservedTime() {
        return $this->reservedTime;
    }
    public function setReservedTime($reservedTime) {
        $this->reservedTime = $reservedTime;
    }
}
?>