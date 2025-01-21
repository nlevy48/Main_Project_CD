<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
// receives data from arduino oand saves it to sql

$servername = "localhost";
$username = "noahlevy";
$password = "angus999";
$dbname = "SepticTankEnvironmentalConditions";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(["error" => "Connection failed: " . $conn->connect_error]);
    exit();
}

// Check if randomNumber is set and is a valid integer
if (isset($_POST['water_level_value']) && filter_var($_POST['water_level_value'], FILTER_VALIDATE_INT) !== false && 
    isset($_POST['turbidity_value']) && filter_var($_POST['turbidity_value'], FILTER_VALIDATE_INT) !== false && 
    isset($_POST['temperature_value']) && filter_var($_POST['temperature_value'], FILTER_VALIDATE_INT) !== false && 
    isset($_POST['methane_value']) && filter_var($_POST['methane_value'], FILTER_VALIDATE_INT) !== false) {
    $water_level = $_POST['water_level_value'];
    $turbidity = $_POST['turbidity_value'];
    $temperature = $_POST['temperature_value'];
    $methane = $_POST['methane_value'];

    // Prepare and bind
    $water_level_stmt = $conn->prepare("INSERT INTO Water_Level (value) VALUES (?);");
    if ($water_level_stmt) {
        $water_level_stmt->bind_param("i", $water_level);

        // Execute the statement
        if ($water_level_stmt->execute()) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $water_level_stmt->error;
        }

        // Close the statement
        $water_level_stmt->close();
    } else {
        echo "Error: " . $conn->error;
    }
} else {
    echo "Invalid input";
    exit();
}

$turbidity_stmt = $conn->prepare("INSERT INTO Turbidity (value) VALUES (?);");
if ($turbidity_stmt) {
    $turbidity_stmt->bind_param("i", $turbidity);

    // Execute the statement
    if ($turbidity_stmt->execute()) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $turbidity_stmt->error;
    }

    // Close the statement
    $turbidity_stmt->close();
} else {
    echo "Error: " . $conn->error;
    exit();
}

$temperature_stmt = $conn->prepare("INSERT INTO Temperature (value) VALUES (?);");
if ($temperature_stmt) {
    $temperature_stmt->bind_param("i", $temperature);

    // Execute the statement
    if ($temperature_stmt->execute()) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $temperature_stmt->error;
    }

    // Close the statement
    $temperature_stmt->close();
} else {
    echo "Error: " . $conn->error;
    exit();
}

$methane_stmt = $conn->prepare("INSERT INTO Methane (value) VALUES (?);");
if ($methane_stmt) {
    $methane_stmt->bind_param("i", $methane);

    // Execute the statement
    if ($methane_stmt->execute()) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $methane_stmt->error;
    }

    // Close the statement
    $methane_stmt->close();
} else {
    echo "Error: " . $conn->error;
    exit();
}
// Close the connection
$conn->close();
?>