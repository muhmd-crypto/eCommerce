<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Access-Control,Content-Type,Access-Control-Allow-Methods,Authorization,X-Requested-With');


include_once('../core/init.php');

$cart = new CART($db);
$product = new PRODUCT($db);

$cart->session_id = $_GET['session_id'] ? $_GET['session_id'] : die();
$data = json_decode(file_get_contents("php://input"));
$cart->product_id = $data->product_id;
$cart->quantity = $data->quantity;
$product->product_id = $data->product_id;

if($product->read_single())
{
    $cart->product_id = $product->product_id;
    $cart->product_name = $product->product_name;
    $cart->product_image = $product->image;
    $cart->product_l_image = $product->l_image;
    $cart->P_Now = $product->P_Now;
    $cart->model_nb = $product->model_nb;
    $cart->Total = ($cart->quantity)*($cart->P_Now);

    if(!$cart->read_single())
    {
        if($cart->create())
        {
            echo json_encode(array("Message"=>"New Item Inserted Inside the Cart"));
        }
        else
        {
            echo json_encode(array("Message"=>"Failed To Add Item"));
        }
    }
    else
    {
        if($cart->update_quantity())
        {
            echo json_encode(array("Message"=>"Quantity updated Successfully"));
        }
        else
        {
            echo json_encode(array("Message"=>"Failed To Update Quantity"));
        }
    }
}
else
{
    echo json_encode(array("Message"=>"Product Not Found"));
}
?>