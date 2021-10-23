<?php
$servername = "sql308.ihweb.ir";
$username = "ihweb_29931358";
$password = "hpjfnkw1";
$dbname = "ihweb_29931358_test";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT username, comment FROM comments";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "username: " . $row["username"]. " - comment: " . $row["comment"]. "<br>";
    }
} else {
    echo "0 results";
}
$conn->close();
?> 