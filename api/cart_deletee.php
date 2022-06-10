<?php
require '../vendor/autoload.php';
use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
header('Connection: keep-alive');

include_once('../core/init.php');

$cart = new CART($db);
$product = new PRODUCT($db);

$headers = getallheaders();
$jwt = $headers["Authorization"];
if(!empty($jwt))
{
    try{
        $secret_key = "owt125";
        $jwt_data = JWT::decode($jwt,new Key($secret_key,'HS512'));
        $cart->user_id = $jwt_data->data->id;
        $cart->product_id = $_GET['product_id'] ? $_GET['product_id'] : die();
        $product->product_id = $cart->product_id;
        if($cart->read_single())
        {
            if($cart->delete())
            {
                echo json_encode(array('Message'=>'Product Deleted From The Cart'));
            }
            else
            {
                echo json_encode(array('Message'=>'Delete Operation Failed'));
            }
        }   
        else
        {
            echo json_encode(array('Message'=>'Product Is Not Found'));
        }
    }
    catch(Exception $ex)
    {
        echo json_encode(array("Message"=>$ex->getMessage()));
    }
}
else
{
    echo json_encode(array("Message"=>"JWT not Found"));
}
?>