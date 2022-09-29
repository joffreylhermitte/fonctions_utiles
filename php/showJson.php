<?php
function showJson($data){
    header("Content-type: application/json");
    $json = json_encode($data,JSON_PRETTY_PRINT);
    if($json){
        die($json);
    } else {
        die("error");
    }

}