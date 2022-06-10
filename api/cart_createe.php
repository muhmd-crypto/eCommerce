<?php

require '../vendor/autoload.php';
use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST,GET,PUT');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods,Authorization,X-Requested-With');
header('Connection: keep-alive');

include_once('../core/init.php');

$product = new PRODUCT($db);
$cart = new CART($db);

$data = json_decode(file_get_contents("php://input"));
if(!empty($data->product_id)&&!empty($data->quantity))
{
    $headers = getallheaders();
    $jwt = $headers["Authorization"];

    if(!empty($jwt))
    {
        try
        {
            $secret_key = "owt125";
            $jwt_data = JWT::decode($jwt,new Key($secret_key,'HS512'));

            $cart->user_id = $jwt_data->data->id;
            $cart->product_id = $data->product_id;
            $cart->quantity = $data->quantity;
            $product->product_id = $data->product_id;

            if($product->read_single())
            {
                $cart->product_name = $product->product_name;
                $cart->product_image = $product->image;
                $cart->product_l_image = $product->l_image;
                $cart->P_Now = $product->P_Now;
                $cart->model_nb = $product->model_nb;
                $cart->Total = ($cart->quantity) * ($product->P_Now);

                if(!$cart->read_single())
                {
                    if($cart->create())
                    {
                        echo json_encode(array('Message'=>'New Porduct Inserted Inside The Cart'));
                    }
                    else
                    {
                        echo json_encode(array('Message'=>'Mission Failed'));
                    }
                }
                else
                {
                    $cart->Total = ($cart->quantity) * ($cart->P_Now);
                    if($cart->update_quantity())
                    {
                        echo json_encode(array('Message'=>'Product Quantity Updated Successfully'));
                    }
                    else
                    {
                        echo json_encode(array('Message'=>'Error while updating Quantity'));
                    }
                }
            }
            else
            {
                echo json_encode(array('Message'=>'Product Not Found'));
            }
        }
        catch(Exception $ex)
        {
            echo json_encode(array("Message"=>$ex->getMessage()));
        }
    }
    else
    {
        echo json_encode(array("Message"=>"There is No Token Entry"));
    }
}
else
{
    echo json_encode(array("Message"=>"All Data Is Required"));   
}