<?php

$url = "https://api.au-syd.natural-language-understanding.watson.cloud.ibm.com/instances/2cdeec84-12c7-4ebc-aa0b-10c15b38f405/v1/analyze?version=2021-08-01";

$curl = curl_init($url);
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

$headers = array(
    "Content-Type: application/json",
    "Authorization: Basic YXBpa2V5OjNqY0o1S3ltT1RDU1VfLUkxeVg0N3hjQWZiOU0tbGN5SzhlTTlmcmRwcU02",
);
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
$text="f ";
#$text=json_encode($text);
#var_dump($text);
$data = <<<DATA
{
  "text":"'.$text.'",
  "features": {
    "emotion": {
      
    }
  }
}
DATA;

curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

//for debug only!
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

$resp = curl_exec($curl);
curl_close($curl);
var_dump($resp);
echo "first dump done <br>";
$resp=json_decode($resp, true);
$emotion=$resp['emotion'];
$emotion=$emotion['document'];
$emotion=$emotion['emotion'];
var_dump($emotion);
echo "first dump done <br>";
$anger=$emotion['anger'];
$disgust=$emotion['disgust'];
echo $anger;
echo $disgust;

?>