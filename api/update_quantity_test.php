<?php
require '../vendor/autoload.php';
use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods,Authorization,X-Requested-With');

include_once '../core/init.php';

$cart = new CART($db);

$cart->product_id = $_GET['product_id'] ? $_GET['product_id'] : die();
$headres = getallheaders();
$jwt = $headres["Authorization"];
if(!empty($jwt))
{
    try{
        $secret_key = "owt125";
        $jwt_data = JWT::decode($jwt,new Key($secret_key,'HS512'));
        $cart->user_id = $jwt_data->data->id;
        $data = json_decode(file_get_contents("php://input"));
        if($cart->quantity_read_single())
        {
            $cart->quantity = $data->quantity;
            $cart->Total = ($cart->quantity) * ($cart->P_Now);
            if($cart->update_quantity())
            {
                echo json_encode(array('Message'=>'Quantity Updated'));
            }
            else
            {
                echo json_encode(array('Message'=>'Error while updating quantity'));
            }
        }
        else
        {
            echo json_encode(array("Message"=>"Product Not Found"));
        }
    }
    catch(Exception $ex)
    {
        echo json_encode(array('Message'=>$ex->getMessage()));
    }
}
else
{
    echo json_encode(array('Message'=>'JWT not found'));
}
?>