<?php

require '../vendor/autoload.php';
use \Firebase\JWT\JWT;

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods,Authorization,X-Requested-With');



include_once('../core/init.php');

$user = new USER($db);

$data = json_decode(file_get_contents("php://input"));

$headers = getallheaders();
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
                $iss = "localhost";
                $iat = time();
                $nbf = $iat + 10;
                $exp = $iat + 60;
                $aud = "myusers";
                $user_arr_data = array(
                    "id"=> $user->user_id,
                    "name"=>$user->username
                );
            
                $secret_key = "owt125";
            
                $payload_info = array(
                    "iss" => $iss,
                    "iat" => $iat,
                    "nbf" => $nbf,
                    "exp" => $exp,
                    "aud" => $aud,
                    "data"=> $user_arr_data
                );
                $jwt = JWT::encode($payload_info, $secret_key, 'HS512');
                echo json_encode(array('Message' => 'User Created Successfully',
                                        'jwt' => $jwt));
            }
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
else
{
    echo json_encode(array("Message"=>"All data Required"));
}

?>