<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once('../core/init.php');
session_start();

if(!isset($_SESSION["user"]))
{
    $_SESSION["user"] = "hello";
  echo json_encode(array("Message"=>"New Session Generated",
                        "session_id"=>session_id(),
                        "data"=>$_SESSION["user"]));
}
if(isset($_SESSION["user"]))
{
    echo json_encode(array("session_id"=>session_id()));
}
?>
