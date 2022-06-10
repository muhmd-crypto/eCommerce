<?php
header('Access-Control-Allow-Origin:*');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods:POST');
header('Access-Control-Allow-Headers:Access-Control-Allow-Headers,Access-Control-Allow-Methods,Content-Type,Authorization,X-Requested-With');



include_once('../core/init.php');
$message=new MESSAGE($db);
$data = json_decode(file_get_contents("php://input"));
$message->Name = $data->Name;
$message->Email = $data->Email;
$message->Message = $data->Message;

if($message->create())
{
    echo json_encode(array("Message"=>"Message Sended"));
}
else
{
    echo json_encode(array("Message"=>"Sending Operation Failed"));
}
?>