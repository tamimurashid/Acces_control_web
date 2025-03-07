<?php 
include"../server/db.php";
header('Access-Control-Allow-Origin:*');
header('Content-Type: application/json');
header('Acess-Control-Allow-Method: GET');
header('Acess-Control-Allow-Headers: Content-Type, Acess-Control-Allow-Headers, Authorization, X-Request-With');

$rawData = file_get_contents("php://input");

$data =  json_decode($rawData , true);// this return php array and not object

if(isset($data['cardID']) || isset($data['code'])){
    if($data['code'] == '010'){
        $res_data =[
            "status" => 'reg_mod',
            "code" => '010',
            "message" =>"Registration on pogress"
        ];
        echo json_encode($res_data);
    }
    elseif($data['code'] == '009'){
        $res_data = [
            "status" => 'Auth_mod',
            "code" => '009',
            "message" => "Authentication method on"
        ];
    }

}else{
    $res_data = [
        "status" => 'error',
        "code" => '000',
        "message" => "Invalid request: cardID not provided"
    ];

    echo json_encode($res_data);

}