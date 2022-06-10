<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Header: Access-Control-Allow-Header,Content-Type,Access-Control-Allow-Methods,Authorization,X-Requested-With');


include_once('../core/init.php');


$product = new PRODUCT($db);
$cart = isset($_COOKIE["cart"]) ? $_COOKIE["cart"] : "[]";
$cart = json_decode($cart);

$data = json_decode(file_get_contents("php://input"));
$product->product_id = $data->product_id;
$quantity = $data->quantity;

foreach($cart as $item){
    if($item->product_id == $product->product_id){
        $item->quantity = $quantity;
    }
    setcookie("cart",json_encode($cart));
    echo $_COOKIE["cart"];
}
