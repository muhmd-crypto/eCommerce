<?php

//headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Header: Access-Control-Allow-Header,Content-Type,Access-Control-Allow-Methods,Authorization,X-Requested-With');


//initializing our api
include_once('../core/init.php');



$product = new PRODUCT($db);

$data = json_decode(file_get_contents("php://input"));

$product->product_id = $data->product_id;

if($product->read_single()){
    if($product->delete())
    {
        echo json_encode(array('Message'=>'Product deleted'));
    }
    else
    {
        echo json_encode(array('Message'=>'Product not deleted'));
    }
}
else
{
   echo json_encode(array('Message' => 'Product Not Found'));
}
?>