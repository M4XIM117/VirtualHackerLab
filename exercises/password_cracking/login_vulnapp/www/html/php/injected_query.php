<?php
// Create connection to MySQLi database
$servername = 'password_cracking_database_1';
$username = 'root';
$password = 'root';
$dbname = 'users';
$port = 3306;
$conn = mysqli_connect($servername, $username, $password, $dbname, $port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the value of the text input field
$name = $_POST['name'];

// Build and execute MySQLi query
$sql = "SELECT username FROM user WHERE username = '$name'";
$result = mysqli_query($conn, $sql);

// Display the result
if ($result->num_rows > 0) {
    // Output each row of data
    while($row = $result->fetch_assoc()) {
      echo "<div class='result-item'>" . $row["username"] . "</div>";
    }
  } else {
    echo "<div class='result-item'>No results found.</div>";
  }

// Close MySQLi connection
$conn->close();
?>
