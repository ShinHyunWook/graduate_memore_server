<?php
    header("Access-Control-Allow-Origin: *");
//    
//    $first_list = array();
//    for($i = 0; $i<count($result);$i++){
//        $tmp = json_decode($result[$i]->image_name);
//        array_push($first_list,$tmp[0]);
//    }
//    $test = json_encode($first_list);
    $json = '[{';
    
    for($i = 0;$i<count($result);$i++){
        $tmp = json_decode($result[$i]->image_name);
        if($i!=0){
            $json = $json.',{';
        }
    
        $json = $json.'image_name: "';
        $json = $json.$tmp[0].'", location_data : ';
        $json = $json.$result[$i]->location_data;
        $json = $json.'}';
    }

    $json = $json.']';

    print_r($json);
?>