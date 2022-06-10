<?php

  $dsn = 'mysql:host=127.0.0.1; dbname=shop';
  $user ='root';
  $pass = '';
  $option = array(
      PDO::MYSQL_ATTR_INIT_COMMAND =>'SET NAMES utf8'
  );

  try{
      $db = new PDO($dsn,$user,$pass,$option);
      $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
      $db->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);
      $db->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY,true);
  }
  catch(PDOException $e){

    echo "FAILED ".$e->getMessage();

  }


?>