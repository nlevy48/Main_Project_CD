<?php
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
$sql = "SELECT id, random_number FROM random_numbers";
$result = $conn->query($sql);

$data = array();

if ($result->num_rows > 0) {
    // Fetch data and store in array
    while($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
} else {
    echo "0 results";
}
$conn->close();

// Encode data as JSON
echo json_encode($data);
?>