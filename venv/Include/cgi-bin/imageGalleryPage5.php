

<html>

<head>
    <title>Image</title>
</head>

<body>

<img src = "https://s4.uupload.ir/files/colorful-autumn-leaves-871286965014l8g8_t8pl.jpg"\ width="500" height="500"/>

</body>

</html>

<body>

<br>enter you username and comment with no special chars such as single quotation, double quotation and _ <br>

<?php
$baseUrl="http://mafarideh1998.ihweb.ir/cgi-bin/";
$homeUrl="http://mafarideh1998.ihweb.ir/cgi-bin/homeHtml.php";
$url=$baseUrl."".basename($_SERVER['PHP_SELF']);
//echo "complete page url is".$url."<br>";
$tableName=str_replace('.', '', basename($_SERVER['PHP_SELF']));
$servername = "sql308.ihweb.ir";
$serverUsername = "ihweb_29931358";
$password = "hpjfnkw1";
$dbname = "ihweb_29931358_test";
$angerThreshHold=0.5;
$pageName= basename($_SERVER['PHP_SELF']);
$pageName=str_replace(".php","",$pageName);
$pageNumber=str_split($pageName);
$pageNumber=intval($pageNumber[count($pageNumber)-1]);
$pageFormat=preg_replace('/[0-9]+/', '', $pageName);
echo '<form action = "commentInsert.php" method = "GET">
    username: <input type = "text" name = "username" minlength="1" maxlength="30"/>
    comment: <input type = "text" name = "comment" minlength="1" maxlength="250"/>
    <input type = "hidden" name = "origPage" value= '.$url.' />
    <input type = "hidden" name = "servername" value= '.$servername.' />
    <input type = "hidden" name = "serverUsername" value= '.$serverUsername.' />
    <input type = "hidden" name = "password" value= '.$password.' />
    <input type = "hidden" name = "dbname" value= '.$dbname.' />
    <input type = "hidden" name = "tableName" value= '.$tableName.' />
    <input type = "hidden" name = "angerThreshHold" value= '.$angerThreshHold.' />
    <input type = "submit" value="submit comment" />
</form>';
?>


</body>

</html>

<br>Comments below:<br>

<?php

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
    echo "Table comments created successfully<br>";
} else {
    //echo "comments are loaded<br>";
    echo "<br>";
}

$sql = "SELECT username, comment ,reg_date FROM ".$tableName;
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "username:  " . $row["username"]. " - comment:  " . $row["comment"]. " date:  ".$row["reg_date"];
        $text=str_replace(' ', '_', $row["comment"]);
        echo '<form action = "textToVoiceViaButton.php" method = "GET">
        <input type = "hidden" name = "text" value='.$text.' />
        <input type = "hidden" name = "origPage" value= '.$url.' />
        <input type = "submit" value="voice"/>
        </form>';
        echo "<br>";
    }
} else {
    echo "0 comments<br>";
}
$conn->close();
?>

<form method="post">
    <input type="submit" name="perv"
           class="button" value="perv" />

    <input type="submit" name="next"
           class="button" value="next" />

    <input type="submit" name="home"
           class="button" value="home" />
</form>

<?php

if(array_key_exists('perv', $_POST)) {
    button1($baseUrl,$pageFormat,$pageNumber);
}
else if(array_key_exists('next', $_POST)) {
    button2($baseUrl,$pageFormat,$pageNumber);
}
else if(array_key_exists('home', $_POST)) {
    button3($homeUrl);
}
function button1($baseUrl,$pageFormat,$pageNumber) {
    $pervPageNumber=$pageNumber-1;
    $pervPageName=$pageFormat.$pervPageNumber.".php";
    $pervPageUrl=$baseUrl.$pervPageName;
    //echo"pervpageurl is".$pervPageUrl;
    if(file_exists($pervPageName)){
        header("Location: ".$pervPageUrl);
        //echo"next page url is ".$pervPageUrl;
        exit();


    }
    else echo"there is no perv page<br>";
}
function button2($baseUrl,$pageFormat,$pageNumber) {
    $nextPageNumber=$pageNumber+1;
    $nextPageName=$pageFormat.$nextPageNumber.".php";
    $nextPageUrl=$baseUrl.$nextPageName;
    //echo"nextpageurl is".$nextPageUrl;
    if(file_exists($nextPageName)){
        header("Location: ".$nextPageUrl);
        //echo"next page url is ".$nextPageUrl;
        exit();

    }
    else echo"there is no next page<br>";
}

function button3($homeUrl) {
    header("Location: ".$homeUrl);
    //echo"next page url is ".$nextPageUrl;
    exit();
}

?>





