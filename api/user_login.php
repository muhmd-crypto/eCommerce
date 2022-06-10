<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once('../core/init.php');

$user = new USER($db);

$user->email = $_GET['email'] ? $_GET['email'] : die();
$user->password = $_GET['password'] ? $_GET['password'] : die(); 

//hashing password
$user->password = sha1($user->password);

if($user->read_single()){
    echo json_encode(array('Message' => 'Login Successful',
                            'user_id' => $user->user_id,
                            'username'=>$user->username));
}
else{
    echo json_encode(array('Message' => 'Login failed'));
}
?>