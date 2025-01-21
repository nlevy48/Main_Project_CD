<?php
 
// Program acquires data from raspberry pi and sends it to sql database

$servername = "localhost";
$username = "noahlevy";
$password = "angus999";
$dbname = "RandomNumberDatabase";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(["error" => "Connection failed: " . $conn->connect_error]);
    exit();
}

// Check if randomNumber is set and is a valid integer
if (isset($_POST['randomNumber']) && filter_var($_POST['randomNumber'], FILTER_VALIDATE_INT) !== false) {
    $randomNumber = $_POST['randomNumber'];

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO RandomNumbers (value) VALUES (?);");
    if ($stmt) {
        $stmt->bind_param("i", $randomNumber);

        // Execute the statement
        if ($stmt->execute()) {
            echo json_encode(["success" => "New record created successfully"]);
        } else {
            http_response_code(400);
            echo json_encode(["error" => "Error: " . $stmt->error]);
        }

        // Close the statement
        $stmt->close();
    } else {
        http_response_code(400);
        echo json_encode(["error" => "Error: " . $conn->error]);
    }
} else {
    http_response_code(400);
    echo json_encode(["error" => "Invalid input"]);
}

$conn->close();


?>