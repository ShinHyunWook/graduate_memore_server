<?php
 header("Access-Control-Allow-Origin: *");

    if(array_key_exists('status',$result[0])){
        if(array_key_exists(1,$result)){
            $data = "{status: '".$result[0]->status."', id:'".$result[0]->id."', name:'".$result[0]->name."',phoneNumber:'".$result[0]->phoneNumber."', email:'".$result[0]->email."', profile : '".$result[0]->profile."', friend:'1', role:'sender'}";          
        }else{
            $data = "{status: '".$result[0]->status."', id:'".$result[0]->id."', name:'".$result[0]->name."',phoneNumber:'".$result[0]->phoneNumber."', email:'".$result[0]->email."', profile : '".$result[0]->profile."', friend:'1', role:'receiver'}";           
        }
    }else{
        $data = "{id:'".$result[0]->id."', profile : '".$result[0]->profile."', name:'".$result[0]->name."',phoneNumber:'".$result[0]->phoneNumber."', email:'".$result[0]->email."' , friend:'0'}";
    }
    echo $data;
?>