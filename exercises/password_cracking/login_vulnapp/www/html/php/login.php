<?php
    // Connect to database
    $servername = 'password_cracking_database-1';
    $username = 'root';
    $password = 'root';
    $dbname = 'users';
    $port = 3306;

    // Create connection
    $conn = mysqli_connect($servername, $username, $password, $dbname);

    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Retrieve username and password from form
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query database for matching user
    $sql = "SELECT * FROM user WHERE username = '$username' AND password = '$password'";
    $result = mysqli_query($conn, $sql);

    // Check if user exists
    if (mysqli_num_rows($result) > 0) {
        // User exists, redirect to homepage or dashboard
        header("Location: success.html");
    } else {
        // User doesn't exist, show error message
        echo "Invalid username or password";
    }

    // Close connection
    mysqli_close($conn);
?>
