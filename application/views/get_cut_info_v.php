<?php
    header("Access-Control-Allow-Origin: *");

    $json ="[";

    for($i = 0;$i<count($result);$i++){
        
        if($i!=0){
            $json = $json.",";
        }
        
        $json = $json."{";
        $data ="";
        
        foreach($result[$i] as $idx => $val){
            if($idx!="caption"){
                $data = $data.",".$idx.":'".$val."'";  
            }else{
                $data = $data.$idx.":'".$val."'";
            }
        }
        
        $json = $json.$data;
        $json = $json."}";
        
    }

    $json = $json."]";

    echo $json;
?>