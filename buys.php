<?php
$thisWeek;
$nextWeek;
$apiKey = "0ab6b9c6-1773-42b0-b158-624881574376";
$secretKey = "CB5E47EAB416E4CAB656C00789D69D9A";

ini_set('display_errors', 'On');
getPrices();
buyAll();
function makeOrder($price, $los, $quant, $tof, $apiKey, $secretKey){
   // getPrices();
    
    $url = "amount=" . $quant . "&api_key=".$apiKey."&contract_type=". $tof ."&lever_rate=20&price=" . $price . "&symbol=ltc_usd&type=".$los."";
    $hashed = "amount=" . $quant . "&api_key=".$apiKey."&contract_type=". $tof ."&lever_rate=20&price=".$price."&symbol=ltc_usd&type=".$los."&secret_key=".$secretKey;
   
    $hasheds = strtoupper(md5($hashed));    
    $urlsd = $url . "&sign=" . $hasheds;
   
    doPost("https://www.okcoin.com/api/v1/future_trade.do", $urlsd);
    
}
function buyAll(){
    global $thisWeek, $nextWeek, $apiKey, $secretKey;
//    if($thisWeek > $nextWeek){
if(true){
    makeOrder($thisWeek, 2, 1, "next_week", $apiKey, $secretKey);
 makeOrder($nextWeek, 1, 1, "quarter", $apiKey, $secretKey);
    }else{
        getPrices();
        buyAll();
    }
}

function getPrices(){
   global $thisWeek, $nextWeek;
    $temp3 = doGet("https://www.okcoin.com/api/v1/future_ticker.do?symbol=ltc_usd&contract_type=next_week");
    $temp2 = doGet("https://www.okcoin.com/api/v1/future_ticker.do?symbol=ltc_usd&contract_type=quarter");

    $thisWeek = json_decode($temp3, true);
    $nextWeek = json_decode($temp2, true);
 //   var_dump($thisWeek);
     //var_dump($thisWeek["ticker"]);
    echo  $thisWeek["ticker"]["last"] . "/" . $nextWeek["ticker"]["last"];
    $thisWeek = $thisWeek["ticker"]["last"];
    $nextWeek =  $nextWeek["ticker"]["last"];
}
function doGet($url){
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $server_output = curl_exec($ch);
  //  echo $server_output;
  return $server_output;
}
function doPost($url, $urls){
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $urls);
    $server_output = curl_exec($ch);
    //echo $server_output;
    curl_close($ch);
    return $server_output;
}
?>