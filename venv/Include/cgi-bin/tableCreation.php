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
$tableName="comments";
// sql to create table
if ($result = query("SHOW TABLES LIKE '".$tableName."'")) {
    if($result->num_rows == 1) {
        echo "Table exists";
    }
}
else {
    echo "Table does not exist";
}
$sql = "CREATE TABLE".$tableName." (
username VARCHAR(30) NOT NULL,
comment VARCHAR(250) NOT NULL,
reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";

if ($conn->query($sql) === TRUE) {
    echo "Table comments created successfully";
} else {
    echo "Error creating table: " . $conn->error;
}

$conn->close();
?> 