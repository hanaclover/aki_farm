<?php

class cart extends session {

	private $item;
	private $cnt;

	public function __construct($key) {
		parent::__construct($key) ;
		$this->item = array();
		$this->cnt = count($_SESSION[$this->sessionKey]);
	}

	public function buttonAdd($id){
		$this->item = $_SESSION[$this->sessionKey];
		/*if(!isset($_SESSION[$this->sessionKey])){	
			$_SESSION[$this->sessionKey] = array();
		}else{ */
		if($this->cnt < 4 ){
			if(!in_array($id, $this->item)){
				array_push( $this->item, $id );
				$this->updateSession($this->item);
				return $_SESSION[$this->sessionKey] ;
			}else{	
				return $_SESSION[$this->sessionKey] ;
			}
		}else
		echo "max cart !!";
		return $this->item ; 
	}
	
	public function buttonDel($btnKey){
		$this->item = $_SESSION[$this->sessionKey];
		$key = array_search($btnKey, $this->item);
		unset($this->item[$key]);
		$this->updateSession($this->item);
		return $_SESSION[$this->sessionKey] ;
	}

//do with javascript, stanby...
	public function goCart(){
			
	}

}

?>
