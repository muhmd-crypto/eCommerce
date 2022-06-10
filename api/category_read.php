<?php

//headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');


//initializing our api
include_once('../core/init.php');

$category = new Categories($db);
//getting results
$result = $category->read();

$num = $result->rowCount();

if($num > 0){
    $category_arr = array();
    while($row = $result->fetch(PDO::FETCH_ASSOC)){
        extract($row);
        $category_item = array(
            'id' => $id,
            'category_name' => $name,
            'created_at' => $created_at
        );
        array_push($category_arr,$category_item);
    }
    echo json_encode($category_arr);

}else{
    echo json_encode(array('Message' => 'No Categories found'));
}

?>