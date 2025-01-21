<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
// receives data from arduino and saves it to sql
$servername = "localhost";
$username = "noahlevy";
$password = "angus999";
$dbname = "SepticTankEnvironmentalConditions";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(["error" => "Connection failed: " . $conn->connect_error]);
    die("Connection failed: " . $conn->connect_error);
}

// Check if randomNumber is set and is a valid integer
if (isset($_POST['water_level_sensor']) && filter_var($_POST['water_level_sensor'], FILTER_VALIDATE_INT) !== false) {
    $water_level = $_POST['water_level_sensor'];

    // Prepare and bind
    $water_level_stmt = $conn->prepare("INSERT INTO Water_Level (water_level_value) VALUES (?);");
    if ($water_level_stmt) {
        $water_level_stmt->bind_param("i", $water_level);

        // Execute the statement
        if ($water_level_stmt->execute()) {
            echo json_encode(["success" => "New water level record created successfully"]);
        } else {
            http_response_code(400);
            echo "Error: " . $water_level_stmt->error;
        }

        // Close the statement
        $water_level_stmt->close();
    } else {
        echo "Error: " . $conn->error;
    }
} else {
    echo "Invalid input 1";
}

if (isset($_POST['turbidity_sensor']) && filter_var($_POST['turbidity_sensor'], FILTER_VALIDATE_INT) !== false) {
    $turbidity = $_POST['turbidity_sensor'];

    // Prepare and bind
    $turbidity_stmt = $conn->prepare("INSERT INTO Turbidity (turbidity_value) VALUES (?);");
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
    }
} else {
    echo "Invalid input 2";
}

if (isset($_POST['temperature_sensor']) && filter_var($_POST['temperature_sensor'], FILTER_VALIDATE_INT) !== false) {
    $temperature = $_POST['temperature_sensor'];

    // Prepare and bind
    $temperature_stmt = $conn->prepare("INSERT INTO Temperature (temperature_value) VALUES (?);");
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
    }
} else {
    echo "Invalid input 3";
}

if (isset($_POST['methane_sensor']) && filter_var($_POST['methane_sensor'], FILTER_VALIDATE_INT) !== false) {
    $methane = $_POST['methane_sensor'];

    // Prepare and bind
    $methane_stmt = $conn->prepare("INSERT INTO Methane_Level (methane_value) VALUES (?);");
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
    }
} else {
    echo "Invalid input 4";
}
// Close the connection
$conn->close();
?>