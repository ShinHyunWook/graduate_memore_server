<?php
//    header("Access-Control-Allow-Origin: *");
//    
//    $image_array = array();
//    $image_array = json_decode($result[0]->image_name);
//
//    print_r($result);




//    $array = array(
//        'caption' => $result[0]->caption,
//        'image_array' => $image_array
//    );
//    $json = json_encode($array['image_array']);
//
//    print_r($json);
//    echo "<br/>";
//    print_r($array);
//    echo "<br/>";
//    print_r($image_array);



    header("Access-Control-Allow-Origin: *");

    $json ="[";

    for($i = 0;$i<count($result);$i++){
        
        if($i!=0){
            $json = $json.",";
        }
        
        $json = $json."{";
        $data ="";
        
        foreach($result[$i] as $idx => $val){
            if($idx!="id"){
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