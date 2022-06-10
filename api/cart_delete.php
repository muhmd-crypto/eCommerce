<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods,Authorization,X-Requested-With');

include_once('../core/init.php');

$cart = new CART($db);

$cart->session_id = $_GET['session_id'] ? $_GET['session_id'] : die();
$cart->product_id = $_GET['product_id'] ? $_GET['product_id'] : die();

if($cart->read_single())
{
    if($cart->delete())
    {
        echo json_encode(array("Message"=>"Item Deleted From The Cart"));
    }
    else
    {
        echo json_encode(array("Message"=>"Delete Operation Failed"));
    }
//       echo json_encode(array("Message"=>"Item is Found"));
}
else
{
    echo json_encode(array("Message"=>"Product Is Not Found"));
}