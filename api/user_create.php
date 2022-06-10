<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods,Authorization,X-Requested-With');



include_once('../core/init.php');

$user = new USER($db);

$data = json_decode(file_get_contents("php://input"));

if(!empty($data->fullName)&&!empty($data->email)&&!empty($data->username)&&!empty($data->password))
{
    $user->fullName = $data->fullName;
    $user->email = $data->email;
    $user->username = $data->username;
    $user->password = $data->password;
    //hashing password
    $user->password = sha1($user->password);
    if(!$user->read_single())
    {
        if($user->create())
        {
            if($user->read_single())
            {
                echo json_encode(array('Message' => 'User Created Successfully'));
            }
            else
            {
                echo json_encode(array('Message' => 'Failed To Add User'));
            }
        }
        else
        {
        echo json_encode(array('Message'=>'user already exist'));
        }
    }
}
else
{
    echo json_encode(array("Message"=>"All data Required"));
}
?>