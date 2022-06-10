<?php

//headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Header: Access-Control-Allow-Header,Content-Type,Access-Control-Allow-Methods,Authorization,X-Request-With');

include_once('../core/init.php');

$category = new Categories($db);

$data = json_decode(file_get_contents("php://input"));

$category->id = $data->id;

if($category->delete()){
    echo json_encode(array('message'=>'Category Deleted'));
}else{
    echo json_encode(array('message'=>'Category not deleted'));
}
?>