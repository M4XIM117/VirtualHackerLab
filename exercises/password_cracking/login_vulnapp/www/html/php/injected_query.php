<?php
// Create connection to MySQLi database
$conn = new mysqli("localhost", "username", "password", "database_name");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the value of the text input field
$name = $_POST['name'];

// Build and execute MySQLi query
$sql = "SELECT * FROM users WHERE name='$name'";
$result = $conn->query($sql);

// Display the result
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "Name: " . $row["name"]. "<br>";
        echo "Email: " . $row["email"]. "<br>";
        echo "Phone: " . $row["phone"]. "<br>";
    }
} else {
    echo "0 results";
}

// Close MySQLi connection
$conn->close();
?>
