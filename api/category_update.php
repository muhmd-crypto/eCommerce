<?php
//headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Header: Access-Control-Allow-Header,Content-Type,Access-Control-Allow-Methods,Authorization,X-Requested-With');


//initializing our api
include_once('../core/init.php');

$category = new Categories($db);

$data = json_decode(file_get_contents("php://input"));

$category->id = $data->id;
$category->name = $data->name;

if($category->update()){
    echo json_encode(array('message'=>'Category Updated'));
}else{
    echo json_encode(array('message'=>'Category Not Updated'));
}
?>