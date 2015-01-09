<?php
ini_set('display_errors', 'On');
  $ch = curl_init("http://www.handspass.com");
  $fp = fopen("text.txt", "w");
  curl_setopt($ch, CURLOPT_FILE, $fp);
  curl_setopt($ch, CURLOPT_HEADER, 0);
  curl_exec($ch);
  curl_close($ch);
  fclose($fp);
?>