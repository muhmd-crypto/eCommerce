<?php

//headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Header: Access-Control-Allow-Header,Content-Type,Access-Control-Allow-Methods,Authorization,X-Requested-With');


//initializing our api
include_once('../core/init.php');



$product = new PRODUCT($db);

//get the posted data
$data= json_decode(file_get_contents("php://input"));

$product->product_id = $data->product_id;
$product->product_name = $data->product_name;
$product->model_nb = $data->model_nb;
$product->quantity = $data->quantity;
$product->puff = $data->puff;
$product->P_Was = $data->P_Was;
$product->P_Now = $data->P_Now;
$product->saving_percentage = $data->saving_percentage;
$product->description = $data->description;
$product->l_description = $data->l_description;
$product->image = $data->image;
$product->category_id = $data->category_id;

if($product->update()){
    echo json_encode(array('message' => 'Product updated'));
}else{
    echo json_encode(array('message' => 'Product not updated'));
}