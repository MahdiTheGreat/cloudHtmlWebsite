
<html>

<head>
    <title>Image Hyperlink Example</title>
</head>

<body>

<img src = "https://s4.uupload.ir/files/summer_7i6.jpg"\/>

</body>

</html>

<body>

<?php echo"enter you comment<br>" ?>

<form action = "<?php $_PHP_SELF ?>" method = "GET">
    username: <input type = "text" name = "username" />
    comment: <input type = "text" name = "comment" />
    <input type = "submit" />
</form>

</body>

</html>

<?php echo"Comments below<br>" ?>
<?php
$servername = "sql308.ihweb.ir";
$serverUsername = "ihweb_29931358";
$password = "hpjfnkw1";
$dbname = "ihweb_29931358_test";
$tableName="comments";

// Create connection
$conn = new mysqli($servername, $serverUsername, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "CREATE TABLE ".$tableName." (
username VARCHAR(30) NOT NULL,
comment VARCHAR(250) NOT NULL,
reg_date VARCHAR(250) NOT NULL
)";
if ($conn->query($sql) === TRUE) {
    echo "Table comments created successfully";
} else {
    echo "comments are loaded<br>";
}

$sql = "SELECT username, comment ,reg_date FROM ".$tableName;
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "username:  " . $row["username"]. " - comment:  " . $row["comment"]. "date:  ".$row["reg_date"];
        $text=str_replace(' ', '_', $row["comment"]);
        echo '<form action = "textToVoiceViaButton.php" method = "GET">
        <input type = "hidden" name = "text" value='.$text.' />
        <input type = "submit" name="comment"/>
        </form>';
        echo "<br>";
    }
} else {
    echo "0 comments";
}
$conn->close();
?>


<?php
if(isset($_GET['username']) || isset($_GET['comment'] )) {
    $servername = "sql308.ihweb.ir";
    $serverUsername = "ihweb_29931358";
    $password = "hpjfnkw1";
    $dbname = "ihweb_29931358_test";
    $username = $_GET['username'];
    $comment = $_GET["comment"];
    unset($_GET['username']);
    unset($_GET['comment']);
    $reg_date = "" . date("Y-m-d") . " " . date("h:i:sa") . "";
    $tableName="comments";

    echo "input is: ";
    echo "username: " . $username . " - comment: " . $comment. " date: ".$reg_date."<br>";
// Create connection
    $conn = new mysqli($servername, $serverUsername, $password, $dbname);
// Check connection
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

//for debug only!
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
        //var_dump($emotion);
        //echo "<br>";
        $anger = $emotion['anger'];

        if ( $anger < 0.6) {

            $sql = "INSERT INTO ".$tableName." (username,comment,reg_date)
            VALUES ('$username','$comment','$reg_date')";
            if ($conn->query($sql) === TRUE) {
                echo "New comment created successfully";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
            $conn->close();

        } elseif ( $anger > 0.6) {
            echo "offensive comment <br>";
        }
    }


    echo "now redirecting";
    header("Location: http://mafarideh1998.ihweb.ir/cgi-bin/imageHtml.php");
    exit();
}
?>




