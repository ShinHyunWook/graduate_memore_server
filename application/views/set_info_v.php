<?php
 header("Access-Control-Allow-Origin: *");

//    $result = json_encode($result[0]->name);
//    $data = array(
//        'name' => $result[0]->name,
//        'phoneNumber'=> $result[0]->phoneNumber
//    );
$data = "{name:'".$result[0]->name."',phoneNumber:'".$result[0]->phoneNumber."', profile:'".$result[0]->profile."', password:'".$result[0]->password."', email : '".$result[0]->email."'}";
    echo $data;
    // 성공하면 1
?>