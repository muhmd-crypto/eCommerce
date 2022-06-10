<?php

 header('Access-Control-Allow-Origin:*');
 header('Content-Type: aaplication/json');

 include_once('../core/init.php');

 $product= new PRODUCT($db);
 $product->category_id = isset($_GET["category_id"]) ? $_GET["category_id"] : die(); 
 $result = $product->read_by_category_id();

 //get the row count
 $num = $result->rowCount();
 
 if($num>0)
 {
     $product_arr = array();
 
     while($row = $result->fetch(PDO::FETCH_ASSOC)){
         extract($row);
         $product_item = array(
             'product_id' => $product_id,
             'product_name' => $product_name,
             'model_nb' => $model_nb,
             'quantity' => $quantity,
             'P_Was' => $P_Was,
             'P_Now' => $P_Now,
             'saving_percentage' => $saving_percentage,
             'description' => $description,
             'l_description' => $l_description,
             'image'=> $image,
             'l_image'=> $l_image,
             'category_name' => $category_name,
             'created_at' => $created_at
         );
         array_push($product_arr,$product_item);
     }
     echo json_encode($product_arr);
 }
 else{
     echo json_encode(array('message' => 'No Products found In This Category'));
 
 }


?>