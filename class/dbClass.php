<?php

class Database
{

	public $db_con	= NULL;
	public $db_host	= '';
	public $db_user	= '';
	public $db_pass	= '';
	public $db_name	= '';

	public function __construct( $db_host, $db_user, $db_pass, $db_name )
	{
		$this->db_con	= $this->connectDB( $db_host, $db_user, $db_pass, $db_name );
		$this->db_host	= $db_host;
		$this->db_user	= $db_user;
		$this->db_pass	= $db_pass;
		$this->db_name	= $db_name;
	}

	private function connectDB( $db_host, $db_user, $db_pass, $db_name )
	{
		$tmp_con = mysqli_connect( $db_host, $db_user, $db_pass, $db_name );

		if( $tmp_con !== false ) {
			return $tmp_con ;
		} else {
			printf("Connect failed: %s/n", mysqli_connect_error());
			exit;
		}
	}

	public function execute ( $sql )
	{
		return mysqli_query( $this->db_con , $sql );
	}

	public function select( $sql )
	{
		$res = $this->execute( $sql );
		$data = array();
		while( $row = mysqli_fetch_assoc( $res ) ) {
		//mysql_fetch_array()‚¾‚ÆƒJƒ‰ƒ€‚Ì’l‚à‚Æ‚ê‚é
			array_push( $data, $row );
		}
		//mysql_free_result( $res );
		return $data;
	}

	public function selectImg( $sql )
	{
		$res = $this->execute( $sql );
		$row = mysqli_fetch_assoc( $res );
		return $row;
	}

	public function close()
	{
		mysqli_close( $this->db_con );
	}


////////////////////////////////////////////////////////////////////////////
	public function quote( $int )
	{
		return mysqli_real_escape_string( $this->db_con , $int );
	}
	public function str_quote( $str )
	{
		return "'" . mysqli_real_escape_string( $this->db_con , $str ) . "'";
	}

	public function getLastId()
	{
		return mysqli_insert_id( $this->db_con );
	}
////////////////////////////////////////////////////////////////////////////

}

