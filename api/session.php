<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST,GET');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods,Authorization,X-Requested-With');


include_once('../core/init.php');
session_start();

if(!isset($_SESSION["user"]))
{
  $session = new SESSION($db);
  
  $_SESSION["user"] = array("session_id"=>session_id(),"logged_at"=>time());
  $session->session_id = session_id();
  $user_ip = isset($_SERVER['HTTP_CLIENT_IP']) ? $_SERVER['HTTP_CLIENT_IP']
  :(isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR']
  :$_SERVER['REMOTE_ADDR']);
  
  $session->user_ip=$user_ip;
  if($session->create())
  {
    $_SESSION["user"] = array("session_id"=>session_id(),"logged_at"=>time());

    echo json_encode(array("Message"=>"New Session Has Been Generated",
                          "session_id"=>session_id()));
  }
  else
  {
    echo json_encode(array("Message"=>"Session Creating Failed"));
  }
}
else
{
  echo json_encode(array("Message"=>"Session Already Exist",
                          "session_id"=>session_id()));
}
?>