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

$sql = "INSERT INTO comments (username,comment)
VALUES ('mahdi', 'hello')";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?> 