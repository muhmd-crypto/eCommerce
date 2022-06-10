<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once('../core/init.php');

$cart = new CART($db);
$cart->session_id = $_GET['session_id'] ? $_GET['session_id'] : die();

$result = $cart->read();

$num = $result->rowCount();
if($num>0)
{
    $cart_items = array();
    while($row=$result->fetch(PDO::FETCH_ASSOC))
    {
        extract($row);
        $item_arr = array(
            'product_id'=>$product_id,
            'product_name'=>$product_name,
            'product_image'=>$product_image,
            'product_l_image'=>$product_l_image,
            'P_Now'=>$P_Now,
            'model_nb'=>$model_nb,
            'quantity'=>$quantity,
            'Total'=>$Total
        );
        array_push($cart_items,$item_arr);
    }
    echo json_encode(array("Message"=>"Your Cart Is Not Empty"),
                            $cart_items);
}
else
{
    echo json_encode(array("Message"=>"Your Cart Is Empty"));
}
?>