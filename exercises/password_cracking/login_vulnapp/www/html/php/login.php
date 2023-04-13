<?php
    // Connect to database
    $servername = 'password_cracking_database_1';
    $username = 'root';
    $password = 'root';
    $dbname = 'users';
    $port = 3306;

    // Create connection
    $conn = mysqli_connect($servername, $username, $password, $dbname, $port);

    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Retrieve username and password from form
    $username = $_POST['username'];
    $password = $_POST['password'];
    $password_hashed = hash("sha256", $password);

    // Query database for matching user
    $sql = "SELECT * FROM user WHERE username = '$username' AND password_hash = '$password_hashed'";
    $result = mysqli_query($conn, $sql);

    if ($result == false){
        echo "Invalid Username or password";
    }
    // Check if user exists
    if (mysqli_num_rows($result) > 0) {
        // User exists, redirect to homepage or dashboard
        header("Location: ../user_query.html");
    } else {
        // User doesn't exist, show error message
        echo "Invalid username or password";
    }

    // Close connection
    mysqli_close($conn);
?>
