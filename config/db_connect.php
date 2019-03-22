<?php

$_conn = mysqli_connect('localhost', 'yerko321', 'pizza', 'todo');

if(!$_conn){
  echo 'Connection error: '. mysqli_connect_error();
}

?>
