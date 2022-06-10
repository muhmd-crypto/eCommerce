<?php
//include vendor folder
require '../vendor/autoload.php';
use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once('../core/init.php');

$user = new USER($db);

$headers = getallheaders();
$jwt = $headers["Authorization"];

if(!empty($jwt))
{
    try{
    $secret_key = "owt125";
    $jwt_data = JWT::decode($jwt,new Key($secret_key,'HS512'));
    echo json_encode(array("message"=>"we got a JWT",
                            "user_data"=>$jwt_data->data->id
        ));
        }catch(Exception $ex)
        {
            echo json_encode(array("message"=>"expired token"));
        }
}