<?php
$fileName="test.txt";
//$text=file_put_contents($fileName,file_get_contents("https://uupload.ir/view/shortstory_mz31.txt/"));
$text=file_get_contents($fileName);
echo "short story is <br>";
echo "hello this shit gay ".$text;
echo"done";
$text=str_split($text);
$l=0;
//echo count($text);
$charLimit=100;
for ($i = 0; $i <count($text); $i=$i+$l+1) {
    if ($i+$charLimit<count($text)){$l=$i+$charLimit;}
    else{$l=count($text);}
    for ($j = $i; $j < $l; $j++) {
        echo $text[$j];
    }
    echo"<br>";
}
?>