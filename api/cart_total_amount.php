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
    $Items_Count = 0;
    $Total_Amount = 0;
    while($row=$result->fetch(PDO::FETCH_ASSOC))
    {
        extract($row);
        $Total_Amount += $Total;
        $Items_Count += $quantity;
    }
    echo json_encode(array("Items_Count"=>$Items_Count
    ,"Total_Amount"=>$Total_Amount));
}
else
{
    echo json_encode(array("Message"=>"Your Cart Is Empty"));
}
?>