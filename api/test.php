<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods,Authorization,X-Requested-With');


include_once('../core/init.php');


session_start();

$product=new PRODUCT($db);

$data = json_decode(file_get_contents("php://input"));
$product->product_id = $data->product_id;
$quantity = $data->quantity;

if(!empty($_SESSION["cart"]))
{
    $item_array_id=array_column($_SESSION["cart"],"product_id");
    if(!in_array($product->product_id,$item_array_id))
    {
        $count = count($_SESSION["cart"]);
        if($product->read_single())
        {
            $item_array = array(
                'product_id'=>$product->product_id,
                'model_nb' => $product->model_nb,
                'product_image' => $product->image,
                'product_l_image' => $product->l_image,
                'P_Now' => $product->P_Now,
                'quantity' => $quantity,
                'total' => ($product->P_Now)*($quantity)
            );
            $_SESSION["cart"][$count] = $item_array;
            echo json_encode(array("Message"=>"Item Added To Cart Successfully"));
            echo json_encode($_SESSION["cart"]);
        }
        else
        {
            echo json_encode(array("Message"=>"Item Is Not Found"));
        }
    }
    else
    {
        foreach($_SESSION["cart"] as $key => $value)
        {
            if($_SESSION["cart"][$key]['product_id']==$product->product_id)
            {
                $_SESSION["cart"][$key]['quantity'] += $quantity;
                $_SESSION["cart"][$key]['total'] = $_SESSION["cart"][$key]['quantity']*$_SESSION["cart"][$key]['P_Now'];
                echo json_encode(array('Message'=>'Quantity Updated Successfully'));
            }
        }
    }
}
else
{
    if($product->read_single()){
    $item_array=array(
        'product_id'=>$product->product_id,
        'model_nb'=>$product->model_nb,
        'product_image'=>$product->image,
        'product_l_image'=>$product->l_image,
        'P_Now'=>$product->P_Now,
        'quantity'=>$quantity,
        'total'=>($product->P_Now)*($quantity)
    );
    $_SESSION["cart"][0]=$item_array;
    echo json_encode(array('Message'=>'New Item Added To The Cart'));
    
    }
    else
    {
        echo json_encode(array('Message'=>'Item Is Not Found'));
    }
}