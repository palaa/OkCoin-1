<?php
function doGet($url){
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $server_output = curl_exec($ch);
  //  echo $server_output;
  return $server_output;
}
?>