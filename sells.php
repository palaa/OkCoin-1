<?php
$thisweek;
$nextweek;
$apiKey = ;
$secretKey = ;
getPrices();
ini_set('display_errors', 'On');
lastAll();
function makeOrder($price, $los, $quant, $tof, $apiKey, $secretKey){
   // getPrices();
    
    $url = "amount=" . $quant . "&api_key=".$apiKey."&contract_type=". $tof ."&lever_rate=20&price=" . $price . "&symbol=ltc_usd&type=".$los."";
    $hashed = "amount=" . $quant . "&api_key=".$apiKey."&contract_type=". $tof ."&lever_rate=20&price=".$price."&symbol=ltc_usd&type=".$los."&secret_key=".$secretKey;
   
    $hasheds = strtoupper(md5($hashed));    
    $urlsd = $url . "&sign=" . $hasheds;
   
    doPost("https://www.okcoin.com/api/v1/future_trade.do", $urlsd);
    
}
function lastAll(){
    global $nextWeek, $thisWeek, $apiKey, $secretKey;
    if(     ((($_GET['last'] - $thisWeek)/$_GET['last']) + (($nextWeek-$_GET['last1'])/$nextWeek)) > 0.002){
   
        echo "Profit " . ((($_GET['last'] - $thisWeek)/$_GET['last']) + (($nextWeek-$_GET['last1'])/$nextWeek));
         makeOrder($thisWeek, "4", "1", "next_week", $apiKey, $secretKey);
          makeOrder($nextWeek, "3", "1", "quarter", $apiKey, $secretKey);
    }else{
        echo "No Profit " . ((($_GET['last'] - $thisWeek)/$_GET['last']) + (($nextWeek-$_GET['last1'])/$nextWeek));
        echo $nextWeek . " / " . $thisWeek;
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
   // echo  $thisWeek["ticker"]["last"] . " " . $nextWeek["ticker"]["last"];
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
    echo $server_output;
    curl_close($ch);
    return $server_output;
}
?>
