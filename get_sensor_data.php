// receives data from arduion oand saves it to sql
<?php
$servername = "localhost";
$username = "noahlevy";
$password = "angus999";
$dbname = "SepticTankEnvironmentalConditions";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if randomNumber is set and is a valid integer
if (isset($_POST['water_level_value']) && filter_var($_POST['water_level_value'], FILTER_VALIDATE_INT) && $_POST['turbidity_value'] && filter_var($_POST['turbidity_value'], FILTER_VALIDATE_INT) && $_POST['temperature_value'] && filter_var($_POST['temperature_value'], FILTER_VALIDATE_INT) &&$_POST['methane_value'] && filter_var($_POST['methane_value'], FILTER_VALIDATE_INT) &&!== false) {
    $water_level = $_POST['water_level_value'];
    $turbidity = $_POST['turbidity_value'];
    $temperature = $_POST['temperature_value'];
    $methane = $_POST['methane_value'];

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO Water_Level (value) VALUES (?);");
    if ($stmt) {
        $stmt->bind_param("i", $water_level);

        // Execute the statement
        if ($stmt->execute()) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    } else {
        echo "Error: " . $conn->error;
    }
} else {
    echo "Invalid input";
}

// Close the connection
$conn->close();
?>