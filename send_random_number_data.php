<?php
// Program sends data from sql database to the html server
// Database connection parameters
$servername = "localhost";
$username = "noahlevy";
$password = "angus999";
$dbname = "RandomNumberDatabase";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to retrieve data
$sql = "SELECT value FROM RandomNumbers ORDER BY created_at DESC LIMIT 1";
$result = $conn->query($sql);

$conn->close();

$json = array();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $json[] = $row;
    }
}

json_encode($json);
?>