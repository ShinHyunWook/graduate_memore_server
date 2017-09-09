<?php
    header("Access-Control-Allow-Origin: *");
    
    if($result!=0){
        $json ="[";

        for($i = 0;$i<count($result);$i++){

            if($i!=0){
                $json = $json.",";
            }

            $json = $json."{";
            $data ="";

            foreach($result[$i] as $idx => $val){
                if($idx!="image_name"){
                    $data = $data.",".$idx.":'".$val."'";  
                }else{
                    $data = $data.$idx.":'".$val."'";
                }
            }
//            if(!array_key_exists("caption",$result[$i])){
//                $data = $data.",caption:''";
//            }            


            $json = $json.$data;
            $json = $json."}";

        }

        $json = $json."]";

        print_r($json);
    }
?>