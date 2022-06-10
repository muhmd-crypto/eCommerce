<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once('../core/init.php');
require('../api/session.php');

$cart = $_SESSION["cart"];
if(!empty($cart))
{
    echo json_encode($cart);
}
else
{
    echo json_encode(array('Message'=>'No Item Exist In the Cart'));
}
?>