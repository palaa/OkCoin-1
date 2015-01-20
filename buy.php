<?php
$thisWeek;
$nextWeek;
$apiKey = //APIKEY;
$secretKey = //SECRET_KEY

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
if($thisWeek < $nextWeek){
    makeOrder($thisWeek, 1, 1, "this_week", $apiKey, $secretKey);
 makeOrder($nextWeek, 2, 1, "next_week", $apiKey, $secretKey);
    }else{
        getPrices();
        buyAll();
    }
}

function getPrices(){
   global $thisWeek, $nextWeek;
    $temp3 = doGet("https://www.okcoin.com/api/v1/future_ticker.do?symbol=ltc_usd&contract_type=this_week");
    $temp2 = doGet("https://www.okcoin.com/api/v1/future_ticker.do?symbol=ltc_usd&contract_type=next_week");

    $thisWeek = json_decode($temp3, true);
    $nextWeek = json_decode($temp2, true);
 //   var_dump($thisWeek);
     //var_dump($thisWeek["ticker"]);
    echo  $thisWeek["ticker"]["sell"] . "/" . $nextWeek["ticker"]["buy"];
    $thisWeek = $thisWeek["ticker"]["sell"];
    $nextWeek =  $nextWeek["ticker"]["buy"];
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
