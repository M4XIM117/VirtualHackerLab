<?php
// MySQL-Verbindung herstellen
$servername = "localhost";
$dbname = "jahresprojekt";

$conn = mysqli_connect($servername, $username, $password, $dbname, $port);

// Überprüfen, ob die Verbindung erfolgreich war
if ($conn->connect_error) {
    die("Verbindung fehlgeschlagen: " . $conn->connect_error);
}

// Registrierungsdaten verarbeiten
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirmPassword = $_POST["confirmPassword"];

    // Überprüfen, ob das Passwort mit der Bestätigung übereinstimmt
    if ($password !== $confirmPassword) {
        die("Die Passwörter stimmen nicht überein");
    }

    // Passwort hashen
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // SQL-Befehl zur Einfügung des Benutzers in die Tabelle "users"
    $sql = "INSERT INTO users (username, email, user_Password)
            VALUES ('$username', '$email', '$hashedPassword')";

    if ($conn->query($sql) === TRUE) {
        echo "Registrierung erfolgreich";
        // Wenn die Registrierung erfolgreich ist, weiterleiten zur index.php
        header("Location: index.php");
    } else {
        echo "Fehler bei der Registrierung: " . $conn->error;
    }
}

$conn->close();
?>
