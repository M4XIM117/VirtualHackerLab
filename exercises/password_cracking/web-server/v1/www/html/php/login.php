<?php
    // Start the session
    session_start();

    // Set the database details
    $servername = "vhl_password_cracking_database-1";
    $username = "your_username";
    $password = "your_password";
    $dbname = "your_database_name";

    // Create the connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Get the login details from the form
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Create the query to check the credentials
    $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($sql);

    // Check if the login details are correct
    if ($result->num_rows > 0) {
        // Save the user's session data
        $_SESSION["username"] = $username;

        // Redirect the user to the homepage
        header("Location: index.php");
    } else {
        // Display an error message
        echo "Invalid username or password.";
    }

    // Close the connection
    $conn->close();
?>
