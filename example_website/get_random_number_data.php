<?php
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

// Check if randomNumber is set and is a valid integer
if (isset($_POST['randomNumber']) && filter_var($_POST['randomNumber'], FILTER_VALIDATE_INT) !== false) {
    $randomNumber = $_POST['randomNumber'];

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO RandomNumbers (value) VALUES (?);");
    if ($stmt) {
        $stmt->bind_param("i", $randomNumber);

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