<?php
//include vendor folder
require '../vendor/autoload.php';
use \Firebase\JWT\JWT;

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once('../core/init.php');

$user = new USER($db);

$user->email = $_GET['email'] ? $_GET['email'] : die();
$user->password = $_GET['password'] ? $_GET['password'] : die(); 

//hashing password
$user->password = sha1($user->password);

if($user->read_single()){
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
    echo json_encode(array('Message' => 'Login Successful',
                            'user_id' => $user->user_id,
                            'username'=>$user->username,
                            'jwt' => $jwt));
}
else{
    echo json_encode(array('Message' => 'Login failed'));
}
?>