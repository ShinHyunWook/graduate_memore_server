<?php
    header("Access-Control-Allow-Origin: *");

    if(count($result)==0){
        echo '';
    }else{
        print_r($result[0]->loc_time);    
    }
?>