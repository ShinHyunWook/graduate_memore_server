<?php
    header("Access-Control-Allow-Origin: *");

    if(count($result)==1){
        echo '100';
    }else{
        echo '200';
    }
?>