<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT,GET');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods,Authorization,X-Requested-With');

include_once '../core/init.php';

$cart = new CART($db);

$cart->session_id = $_GET['session_id'] ? $_GET['session_id'] : die();
$cart->product_id = $_GET['product_id'] ? $_GET['product_id'] : die();

$data = json_decode(file_get_contents("php://input"));
if($cart->quantity_read_single())
{
    $cart->quantity = $data->quantity;
    $cart->Total = ($cart->quantity)*($cart->P_Now);
    if($cart->update_quantity())
    {
        echo json_encode(array("Message"=>"Quantity Updated Successfully"));
    }
    else
    {
        echo json_encode(array("Message"=>"Something went Wrong"));
    }
}
else
{
    echo json_encode(array("Message"=>"Product Is Not Found"));
}
?>