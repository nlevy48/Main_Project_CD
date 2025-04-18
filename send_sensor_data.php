// takes data from sql database, converts it to JSON object which is sent to html
<?php
header('Content-Type: application/json');

// Database connection parameters
$servername = "localhost";
$username = "noahlevy";
$password = "angus999";
$dbname = "SepticTankEnvironmentalConditions";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(['error' => 'Connection failed: ' . $conn->connect_error]));
}

// SQL query to retrieve data
$databases = ["Methane_Level", "Temperature", "Turbidity", "Water_Level"];
$values = ["methane_value", "temperature_value", "turbidity_value", "water_level_value"];

foreach ($databases as $index => $database) {
    $sql = "SELECT id, " . $values[$index] . " FROM " . $database;
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data[$database][] = $row;
        }
    } else {
        $data[$database] = ['message' => 'No results found'];
    }
}

$conn->close();

// Encode data as JSON
echo json_encode($data);
?>