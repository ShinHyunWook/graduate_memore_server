<?php
    header("Access-Control-Allow-Origin: *");
    
    $array = array(
        'id' => $result[0]->id,
        'loc_data' => $result[0]->loc_data
    );
    $json = json_encode($array);

    print_r($json);

?>