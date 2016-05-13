<?php 

class tohash{

public function to_hash($pass){
  $hashed = sha1($pass);
  return $hashed;
}
}

?>
