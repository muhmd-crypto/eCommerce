<?php
header('Access-Control-Allow-Origin:*');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods:POST');
header('Access-Control-Allow-Headers:Access-Control-Allow-Headers,Access-Control-Allow-Methods,Content-Type,Authorizarion,X-Requested-With');


session_start();
error_reporting(0);
include_once('../core/init.php');
$checkout = new CHECKOUT($db);
$cart = new CART($db);
$user = new USER($db);

$cart->session_id = $_GET['session_id'] ? $_GET['session_id'] : die();
$user->user_id = $_GET['user_id'] ? $_GET['user_id'] : die();

if($user->read_by_id())
{
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
        $data = json_decode(file_get_contents("php://input"));
        $checkout->user_id = $user->user_id;
        $checkout->session_id = $cart->session_id;
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
        if(!empty($checkout->firstName)||!empty($checkout->lastName)||!empty($checkout->Zone)||
           !empty($checkout->Address)||!empty($checkout->phone)||!empty($checkout->phone))
        {
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
            echo json_encode(array("Message"=>"All Data Is Required"));
        }
    }
    else
    {
        echo json_encode(array("Message"=>"Your Cart Is Empty !"));
    }
}
else
{
    echo json_encode(array("Message"=>"User is not valid"));
}
?>