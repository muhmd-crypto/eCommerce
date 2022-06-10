<?php

require '../vendor/autoload.php';
use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once('../core/init.php');
$cart = new CART($db);
$headers = getallheaders();
$jwt = $headers["Authorization"];
if(!empty($jwt))
{
    try
    {
        $secret_key = "owt125";
        $jwt_data = JWT::decode($jwt,new Key($secret_key,'HS512'));
        $cart->user_id = $jwt_data->data->id;
        $result = $cart->read();

        $num = $result->rowCount();
        if($num > 0)
        {
            $Total_Amount = 0;
            $Items_Count = 0;
            while($row = $result->fetch(PDO::FETCH_ASSOC))
            {
                extract($row);
                $Total_Amount += $Total ? $Total : ($quantity)*($P_Now);
                $Items_Count++ ;
            }
            echo json_encode(array(
                'Total Amount'=> $Total_Amount,
                'Items Count' => $Items_Count
            ));
        }
        else
        {
            echo json_encode(array("Message"=>"There Is No Item In The Cart"));
        }
    }
    catch(Exception $ex)
    {
        echo json_encode(array("Message"=>$ex->getMessage()));
    }
}
?>