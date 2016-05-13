<?php

class initMaster {
      public static function getDate(){
          $yearArr        = array();
          $monthArr       = array();
          $dayArr         = array();

          $next_year      = date( 'Y' ) + 1;

       for( $i = 1900; $i <= $next_year; $i++ ) {
          $year = sprintf( "%04d", $i );
          $yearArr[$year] = $year; 
       }

       for( $i = 1; $i < 13; $i++ ) {
          $month = sprintf( "%02d", $i );
          $monthArr[$month] = $month;
       }

       for( $i = 1; $i < 32; $i++ ) {
          $day = sprintf( "%02d", $i );
          $dayArr[$day] = $day;
       }

     return array( $yearArr, $monthArr, $dayArr );

     }

   public static function getSex(){
       $sexArr = array('男性','女性');
       return $sexArr;
   }
 }

?>
