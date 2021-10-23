<?php

$url = "https://api.eu-de.text-to-speech.watson.cloud.ibm.com/instances/2ce4e216-2864-40a2-908e-c71531e83ec3/v1/synthesize";

$curl = curl_init($url);
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

$headers = array(
    "Content-Type: application/json",
    "Accept: audio/wav",
    "Authorization: Basic YXBpa2V5Old0RDI4cHFNanFfT3FtVHNaSjA3dTR4RTFCMmQ2Zjdvdkx1VWM4WlcxM29S",
);
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

$data = '{"text":"hello world"}';

curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

//for debug only!
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

$resp = curl_exec($curl);
curl_close($curl);
var_dump($resp);
file_put_contents("test.wav", $resp);
$file = "test.wav";
if (file_exists($file)) {
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="'.basename($file).'"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));
    readfile($file);
    exit;
}
?>


