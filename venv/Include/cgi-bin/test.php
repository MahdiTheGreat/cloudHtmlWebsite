
<?php
$servername = $_GET['servername'];
$serverUsername =  $_GET['serverUsername'];
$password =  $_GET['password'];
$dbname =  $_GET['dbname'];
$username = $_GET['username'];
$comment =  str_replace(array("_", "'", '"'), '', $_GET["comment"]);
$origPage= $_GET["origPage"];
$tableName= $_GET["tableName"];
$angerThreshHold= $_GET["angerThreshHold"];
unset($_GET['username']);
unset($_GET['comment']);

$reg_date = "" . date("Y-m-d") . " " . date("h:i:sa") . "";
echo "input is: ";
echo "username: " . $username . " - comment: " . $comment . " date: ".$reg_date."<br>";
$conn = new mysqli($servername, $serverUsername, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

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
$data = <<<DATA
    {
      "text":"'.$comment.'",
      "features": {
        "emotion": {
          
        }
      }
    }
    DATA;

curl_setopt($curl, CURLOPT_POSTFIELDS, $data);


curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

$resp = curl_exec($curl);
curl_close($curl);
echo "api result is: ";
var_dump($resp);
echo "<br>";

$resp = json_decode($resp, true);
if(isset($resp["error"])){
    $sql = "INSERT INTO ".$tableName." (username,comment,reg_date)
        VALUES ('$username','$comment','$reg_date')";
    if ($conn->query($sql) === TRUE) {
        echo "New comment created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    $conn->close();
}
else {
    $emotion = $resp['emotion'];
    $emotion = $emotion['document'];
    $emotion = $emotion['emotion'];
    var_dump($emotion);
    echo "<br>";
    $anger = $emotion['anger'];
    $disgust=$emotion['disgust']


        if ( $anger <$angerThreshHold and $disgust<$angerThreshHold) {

            $sql = "INSERT INTO ".$tableName." (username,comment,reg_date)
            VALUES ('$username','$comment','$reg_date')";
            if ($conn->query($sql) === TRUE) {
                echo "New comment created successfully";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
            $conn->close();

        } elseif ( $anger > $angerThreshHold or $disgust>$angerThreshHold) {
            echo "offensive comment <br>";
        }
    }

//echo "now redirecting";
//header("Location: ".$origPage);
//exit();
?>

