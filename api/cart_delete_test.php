<?php 
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
//header('Access-Control-Allow-Methods: GET');
//header('Access-Control-Allow-Header :Access-Control-Allow-Header,Access-Control-Allow-Methods,Content-Type,Authorization,X-Requested-With');

include_once('../core/init.php');
require('../api/session.php');

$product = new PRODUCT($db);
$data = json_decode(file_get_contents("php://input"));
$product->product_id = $data->product_id;

if(!empty($_SESSION["cart"]))
{
    foreach($_SESSION["cart"] as $key => $value)
    {
        if($value['product_id'] == $product->product_id)
        {
            unset($_SESSION["cart"][$key]);
            echo json_encode(array('Message'=>'Item Deleted Successfully'));
        }
    }
}

// $cart = isset($_COOKIE["cart"]) ? $_COOKIE["cart"] : "[]";
// $cart = json_decode($cart);
// $cart_new = [];
// $product->product_id = isset($_GET['product_id']) ? $_GET['product_id'] : die();

// if($product->read_single()){
//     foreach($cart as $item){
//         if($item->product_id != $product->product_id){
//             array_push($cart_new,$item);
//         }
//     }
// }
// setcookie("cart",json_encode($cart_new));
// echo $_COOKIE["cart"];
// ?>