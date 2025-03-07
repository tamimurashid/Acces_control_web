<?php 
require "./server/db.php";
header('Access-Control-Allow-Origin:*');
header('Content-Type: application/json');
header('Acess-Control-Allow-Method: GET');
header('Acess-Control-Allow-Headers: Content-Type, Acess-Control-Allow-Headers, Authorization, X-Request-With');

$rawData = file_get_contents("php://input");

$data =  json_decode($rawData , true);// this return php array and not object

if(isset($data['cardID'])){
    $res_data = [


    ];

}else{
    $res_data = [
        "status" => 'error',
        "code" => '000',
        "message" => "Id not serted"
    ];

}