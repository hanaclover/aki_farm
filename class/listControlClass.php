<?php


class control extends Database {

	public function __construct( $db_host, $db_user, $db_pass, $db_name ) {
		parent::__construct( $db_host, $db_user, $db_pass, $db_name ) ;
	}

	public function categorySort($get){
		$query	= 'SELECT img, name, price, detail, category, id, kana FROM akino where category = "'. $get. '"';
		$data = $this->select($query);
		return $data;
	}
	
	public function wordSearch($get){
		$query	= 'SELECT img, name, price, detail, category, id, kana FROM akino where kana like "%'. $get. '%"';
		$data = $this->select($query);
		return $data;
	}

	public function allSelect(){
	    $query = "SELECT img, name, price, detail, category, id, kana FROM akino";
	    $data = $this->select($query);
	    return $data;
	}
    
    public function incrementSearch($word)
    {
	    $query = 'SELECT kana FROM akino where kana like "'. $word. '%"';
	    $data = $this->select($query);
	    return $data;
    }
    
    public function addSelect($arr){
		foreach($arr as $val){	
			$query = 'SELECT img, name, price, detail, category, id, kana FROM akino where id ="'. $val. '"';
			if(empty($data)){
				$data = array();
				array_push($data, $this->selectImg($query));
			}else{
				array_push($data, $this->selectImg($query));
			}
		}
		return $data;
	}
	
	public function detailOpen($get){
		$query = 'SELECT img, name, price, detail, category, id, kana FROM akino where kana ="'. $get. '"';
	    $data = $this->select($query);
	    return $data;	
	}

	public function cartShow($arr){
		foreach($arr as $val){	
			$query = 'SELECT *  FROM akino where id ="'. $val. '"';
			if(empty($data)){
				$data = array();
				array_push($data, $this->selectImg($query));
			}else{
				array_push($data, $this->selectImg($query));
			}
		}
		return $data;
	}
}


?>
