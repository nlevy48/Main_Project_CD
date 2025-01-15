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

$json = array("random_number" => null);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $json["random_number"] = $row["value"];
}

if ($conn->connect_error) {
    echo json_encode(["json" => "Error: " . $conn->connect_error]);
} else {
    echo json_encode($json);
}
?>