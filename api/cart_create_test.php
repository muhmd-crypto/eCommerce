<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Credentials,Access-Control-Allow-Methods,Authorization,X-Requested-With');


include_once('../core/init.php');
require('../api/session.php');

$product = new PRODUCT($db);

$data = json_decode(file_get_contents("php://input"));
$product->product_id = $data->product_id;
$quantity = $data->quantity;

if(isset($_SESSION["cart"]))
{
    $item_array_id = array_column($_SESSION["cart"],"product_id");
    if(!in_array($product->product_id,$item_array_id))
    {
        $count = count($_SESSION["cart"]);
        if($product->read_single())
        {
        $item_array = array(
            'product_id' => $product->product_id,
            'model_nb' => $product->model_nb,
            'product_image' => $product->image,
            'product_l_image' => $product->l_image,
            'P_Now' => $product->P_Now,
            'quantity' => $quantity,
            'total' => ($product->P_Now)*($quantity)
        );
        $_SESSION["cart"][$count] = $item_array;
        echo json_encode(array('Message'=>'Item Added Successfully',
                                'cart'=>$_SESSION["cart"]));
        }
        else
        {
            echo json_encode(array('Message'=>'Item Is Not Found'));
        }
    }
    else
    {
        foreach($_SESSION["cart"] as $value)
        {
            if($value['product_id'] == $product->product_id)
            {
                $value['quantity'] += $quantity;
                $value['total'] = $value['quantity'] * $value['P_Now'];
                echo json_encode(array('Message'=>'Quantity Updated Successfully',
                                        'cart'=>$_SESSION["cart"]));
            }
        }

    }
}
// else
// {
//     if($product->read_single())
//     {
//     $item_array = array(
//         'product_id' => $product->product_id,
//         'model_nb' => $product->model_nb,
//         'product_image' => $product->image,
//         'product_l_image' => $product->l_image,
//         'P_Now' => $product->P_Now,
//         'quantity' => $quantity,
//         'total' => ($product->P_Now)*($quantity)
//     );
//     $_SESSION["cart"][0] = $item_array;
//     echo json_encode(array('Message'=>'New Item Added In The Cart',
//                             'cart'=>$_SESSION["cart"]));
//     }
//     else
//     {
//         echo json_encode(array('Message'=>'Item Is Not Found'));
//     }
// }


// if(isset($_COOKIE["cart"])){
// $cart_item = array_column(array($_COOKIE["cart"]),'product_id');
// if(!in_array($product->product_id,$cart_item)){
//     if($product->read_single()){
//         $cart = array($_COOKIE["cart"]);
//         array_push($cart, array(
//             'product_id' => $product->product_id,
//             'model_nb' => $product->model_nb,
//             'product_image' => $product->image,
//             'product_l_image' => $product->l_image,
//             'P_Now' => $product->P_Now,
//             'quantity' => $quantity,
//             'total' => ($product->P_Now)*($quantity)
//         ));
//         $cart_json = json_encode($cart);
//         $cart_json = stripslashes($cart_json);
//         setcookie("cart",$cart_json,time()+10);
//         echo json_encode(array('Message' => 'New Product inserted inside the cart'));
//         }else{
//         echo json_encode(array('Message' => 'Product Not Found'));
//         }
// }else{
//    foreach($_COOKIE["cart"] as $key => $value){
//          if($_COOKIE["cart"][$key]['product_id'] == $product->product_id){
//              $_COOKIE["cart"][$key]['quantity'] += $quantity;
//              break;
//              }
//             echo json_encode(array('Message'=>'Product Quantity Updated'));
// }
// }else{
//     $new_item = null;
//         if($product->read_single()){
//             $item_array = array(
//             'product_id' => $product->product_id,
//             'model_nb' => $product->model_nb,
//             'product_image' => $product->image,
//             'product_l_image' => $product->l_image,
//             'P_Now' => $product->P_Now,
//             'quantity' => $quantity,
//             'total' => ($product->P_Now)*($quantity)
//              );
//              array_push($new_item,$item_array);
//              $new_item_json = json_encode($new_item); 
//              $new_item_json = stripslashes($new_item_json);
//              setcookie("cart",$new_item_json,time()+10);
//         echo json_encode(array('Message' => 'New Product inserted inside the cart'));
//         }else{
//             echo json_encode(array('Message'=> 'New product is not inserted inside the cart'));
//         }
// }
// $product = new PRODUCT($db);

// $data = json_decode(file_get_contents("php://input"));
// $product->product_id = $data->product_id;
// $quantity = $data->quantity;

// if(isset($_COOKIE["cart"])){
//     $cart = $_COOKIE["cart"];
//     $cart = array($cart);
//     $item_array_id = array_column($cart,$product->product_id);
//     if(!in_array($product->product_id,$item_array_id)){
//         if($product->read_single()){
//             $item_array = array(
//             'product_id' => $product->product_id,
//             'model_nb' => $product->model_nb,
//             'product_image' => $product->image,
//             'product_l_image' => $product->l_image,
//             'P_Now' => $product->P_Now,
//             'quantity' => $quantity,
//             'total' => ($product->P_Now)*($quantity)
//             );
//             array_push($cart,$item_array);
//             $cart_json = json_encode($cart);
//             setcookie("cart",$cart_json,time()+20);
//             echo json_encode(array('Message' => 'Product inserted inside the cart'));
//             }else{
//                 echo json_encode(array('Message'=>'Product is Not Found'));
//                 }
//         }else{
//             $cart = array($_COOKIE["cart"]);
//             foreach($cart as $key => $value){
//             if($cart[$key]['product_id'] == $product->product_id){
//                 $cart[$key]['quantity'] += $quantity;
//                 }
//             }
//         }
// }
// else{
//     $new_item = array();
//     if($product->read_single()){
//         $item_array = array(
//         'product_id' => $product->product_id,
//         'model_nb' => $product->model_nb,
//         'product_image' => $product->image,
//         'product_l_image' => $product->l_image,
//         'P_Now' => $product->P_Now,
//         'quantity' => $quantity,
//         'total' => ($product->P_Now)*($quantity)
//          );
//          array_push($new_item,$item_array);
//          $new_item_json = json_encode($new_item); 
//          setcookie("cart",$new_item_json,time()+10);
//     echo json_encode(array('Message' => 'New Product inserted inside the cart'));
//     }else{
//         echo json_encode(array('Message'=> 'New product is not inserted inside the cart'));
//     }
// }