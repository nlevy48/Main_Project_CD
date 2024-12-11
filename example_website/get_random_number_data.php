<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sensor_database";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get data from POST request
$randomNumber = $_POST['randomNumber'];

// Prepare and bind
$stmt = $conn->prepare("INSERT INTO sensor_data (SensorID, SensorName, SensorValue) VALUES (?, ?, ?)");
$sensorID = 1; // Example sensor ID
$sensorName = "Random Number Generator"; // Example sensor name
$stmt->bind_param("isd", $sensorID, $sensorName, $randomNumber);

// Execute the statement
if ($stmt->execute()) {
    echo "New record created successfully";
} else {
    echo "Error: " . $stmt->error;
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>