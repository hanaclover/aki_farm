<?php

require_once('database_class.php');

class error_check{
    private $dataArr = array();
    private $errArr  = array();
    
    public function __construct(){
    }

    public function errorCheck( $dataArr ){

      $this->dataArr = $dataArr;

      $this->createErrorMessage();

      $this->familyNameCheck();
      $this->firstNameCheck();
      $this->sexCheck();
      $this->birthCheck();
      $this->shopCheck();
      $this->jobCheck();
      $this->IDcheck();
      $this->passwordCheck();
      $this->pwReCheck();
      
      return $this->errArr;

   }

   private function createErrorMessage(){
        foreach( $this->dataArr as $key => $val ){
   //     var_dump($key); 
            $this->errArr[$key]='';
        }
   }
      
   private function familyNameCheck(){
       if ( $this->dataArr['family_name'] === '' ) $this->errArr['family_name'] = 'お名前（氏）を入力してください。';
   }
   private function firstNameCheck(){
       if ( $this->dataArr['first_name'] === '' ) $this->errArr['first_name'] = 'お名前（名）を入力してください。';
   }
   private function sexCheck(){
       if ( $this->dataArr['sex'] === '' ) $this->errArr['sex'] = '性別を入力してください。';
   }

   private function shopCheck(){
       if ( $this->dataArr['shop'] === '') $this->errArr['shop'] = '所属店舗を入力してください。';
   }

   private function jobCheck(){
       if ( $this->dataArr['job'] === '') $this->errArr['job'] = '職種を入力してください。';
   }

   private function birthCheck(){
       if ( $this->dataArr['year'] === '' ) $this->errArr['year'] = '所属年月日の年を入力してください。';
       
       if ( $this->dataArr['month'] === '' ) $this->errArr['month'] = '所属年月日の月を入力してください。';
       
       if ( $this->dataArr['day'] === '' ) $this->errArr['day'] = '所属年月日の日を入力してください。';
       
       if ( $this->dataArr['year'] && $this->dataArr['month'] && $this->dataArr['day'] !== '' ){
       if( checkdate($this->dataArr['month'] , $this->dataArr['day'] , $this->dataArr['year'])=== false){
       $this->errArr['year'] =  '正しい日付けを入力してください。';
       }
       }
       if( strtotime( $this->dataArr['year'] . "-" . $this->dataArr['month'] . "-" .  $this->dataArr['day'] ) - strtotime( "now" ) > 0 ){
       $this->errArr['year'] = '正しい日付けを入力してください。';
       }

   }


      private function IDCheck(){ if( preg_match('/^[a-zA-Z0-9]{6,}$/', $this->dataArr["ID"]) === 0 ){
      $this->errArr['ID']= 'IDは半角英数字6文字以上で入力してください';
   }else{ 
      $db= new database();
      $table= "regist";
      $column = "";
      $where= "User_ID= '" . $this->dataArr["ID"] ."'";
      $arart = $db->IDCheck($table, $column, $where);
      if($arart===1){$this->errArr['ID']= 'このIDは既に登録されています。';}
   }

   }




   private function passwordCheck(){ if(preg_match('/^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z\-]{8,}$/', $this->dataArr["password1"])===0 ) {
      $this->errArr['password1']= 'passwordは半角英数字、大文字小文字数字を混ぜた8文字以上のものを入力してください。';
   }
   }

   private function pwReCheck(){ if ($this->dataArr['password1'] !== $this->dataArr['password2'])
   {
   $this->errArr['password2'] = '相違が見られます。';
   }
   }
  
   public function getErrorFlg(){
        $err_check = true;
        foreach( $this->errArr as $key => $value )
        {
           if( $value !== '' ) $err_check = false;
        }
        return $err_check;
   }

   public function htmlEncode( &$dataArr ){
        foreach( $dataArr as $key => &$data )
        {
             if( is_array ($data ) !== true )
             {
             $dataArr[$key] = htmlspecialchars( $data, ENT_QUOTES );
             }
             else
             {
             $this->htmlEncode( $data );
             }
        }
   }

}




?>
