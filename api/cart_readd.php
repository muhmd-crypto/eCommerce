<?php

require '../vendor/autoload.php';
use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;

header('Access-Control-Allow-Origine: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods,Authorization,X-Requested-With');

include_once('../core/init.php');

$cart = new CART($db);

$headers = getallheaders();
$jwt = $headers["Authorization"];
if(!empty($jwt))
{
    try
    {
        $secret_key = "owt125";
        $jwt_data = JWT::decode($jwt,new Key($secret_key,'HS512'));
        $cart->user_id = $jwt_data->data->id;
        $username = $jwt_data->data->name;
        $result = $cart->read();
        $num = $result->rowCount();

        if($num>0)
        {
            $cart_arr = array();
            while($row = $result->fetch(PDO::FETCH_ASSOC))
            {
                extract($row);
                $item_arr = array(
                    'username' => $username,
                    'product_name' => $product_name,
                    'product_image' => $product_image,
                    'product_l_image' => $product_l_image,
                    'P_Now' => $P_Now,
                    'model_nb' => $model_nb,
                    'quantity' => $quantity,
                    'Total' => $Total ? $Total : ($quantity) * ($P_Now)
                );
                array_push($cart_arr,$item_arr);
            }
            echo json_encode($cart_arr);
        }
        else
        {
            echo json_encode(array('Message'=>'There is No Item Inside The Cart'));
        }
    }
    catch(Exception $ex)
    {
        echo json_encode(array("Message"=>$ex->getMessage()));
    }
}
else
{
    echo json_encode(array("Message"=>"JWT Not Found"));
}
?>