<?php

//headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');


//initializing our api
include_once('../core/init.php');

$category = new Categories($db);

$category->id = isset($_GET['id']) ? $_GET['id'] : die();
$category->read_single();

$category_arr = array(
    'id' => $category->id,
    'name' => $category->name,
    'created_at' => $category->created_at
);

print_r(json_encode($category_arr));