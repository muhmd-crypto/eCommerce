<?php

//headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');


//initializing our api
include_once('../core/init.php');


$product = new PRODUCT($db);

$product->product_id = isset($_GET['product_id']) ? $_GET['product_id'] : die();
if($product->read_single()){
    $product_arr = array(
    'product_name' => $product->product_name,
    'model_nb' => $product->model_nb,
    'quantity' => $product->quantity,
    'puff' => $product->puff,
    'P_Was' => $product->P_Was,
    'P_Now' => $product->P_Now,
    'saving_percentage' => $product->saving_percentage,
    'description' => $product->description,
    'l_description' => $product->l_description,
    'image'=> $product->image,
    'l_image'=> $product->l_image,
    'category_id' => $product->category_id,
    'category_name' => $product->category_name,
    'created_at' => $product->created_at
);

print_r(json_encode($product_arr));
}
else{
    echo json_encode(array('Message' => 'Product Not Found'));
}
?>