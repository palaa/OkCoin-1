<?php
$thisWeek;
$nextWeek;
$lastThisWeek;
$lastNextWeek;

getPrices();
error_reporting(E_ALL);
ini_set('display_errors', 'On');

function doGet($url){
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $server_output = curl_exec($ch);
  //  echo $server_output;
  return $server_output;
}
function buyAll(){
    
}
function sellAll(){
    
}


?>