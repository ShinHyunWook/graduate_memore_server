<?php
 header("Access-Control-Allow-Origin: *");

//    $result = json_encode($result[0]->name);
//    $data = array(
//        'name' => $result[0]->name,
//        'phoneNumber'=> $result[0]->phoneNumber
//    );
if(!$result){
    echo 'empty';
}else{
    $data = "{id:'".$result[0]->id."', name:'".$result[0]->name."',phoneNumber:'".$result[0]->phoneNumber."'}";
    echo $data;
}

    // 성공하면 1
?>