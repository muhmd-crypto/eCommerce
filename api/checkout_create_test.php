<?php
require '../vendor/autoload.php';
use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Method: POST');
header('Access-Control-Allow-Headers:Access-Control-Allow-Headers,Access-Control-Allow-Method,Content-Type,Authorization, X-Requested-With');

include_once('../core/init.php');
error_reporting(0);
$checkout = new CHECKOUT($db);
$cart = new CART($db);

$headers = getallheaders();
$jwt = $headers["Authorization"];

if(!empty($jwt))
{
    try{
        $secret_key = "owt125";
        $jwt_data = JWT::decode($jwt,new Key($secret_key,'HS512'));
        $cart->user_id = $jwt_data->data->id;
        $result = $cart->read();
        $Items_Count = 0;
        $Total_Amount = 0;

        $num = $result->rowCount();
        if($num>0)
        {
            while($row = $result->fetch(PDO::FETCH_ASSOC))
            {
                extract($row);
                $Total_Amount += $Total ? $Total : ($quantity)*($P_Now);
                $Items_Count += 1;
            }
            $data = json_decode(file_get_contents("php://input"));
            $checkout->user_id = $cart->user_id;
            $checkout->firstName = $data->firstName;
            $checkout->lastName = $data->lastName;
            $checkout->Zone = $data->Zone;
            $checkout->Address = $data->Address;
            $checkout->phone = $data->phone;
            $checkout->addressDetails = $data->addressDetails;
            $checkout->paymentMethod = $data->paymentMethod;
            $checkout->cardHolderName = $data->cardHolderName;
            $checkout->cardNumber = $data->cardNumber;
            $checkout->expirationDate = $data->expirationDate;
            $checkout->CVC = $data->CVC;
            $checkout->Items_Count = $Items_Count;
            $checkout->Total_Amount = $Total_Amount;

            if($checkout->create())
            {
                echo json_encode(array('Message'=>'Payment Operation Succeded'));
            }
            else
            {
                echo json_encode(array('Message' => 'Payment Operation Failed'));
            }
        }
        else
        {
            echo json_encode(array('Message'=>'Cart Is Empty'));
        }
    }
    catch(Exception $ex)
    {
        echo json_encode(array('Message'=>$ex->getMessage()));
    }
}
else
{
    echo json_encode(array("Message"=>"JWT Not Found"));
}
?>