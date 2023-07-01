<?php
// MySQL-Verbindung herstellen
$servername = "localhost";
$dbname = "jahresprojekt";

$conn = new mysqli($servername, 'root', 'root', $dbname, 1201);

session_start();

// Überprüfen, ob die Verbindung erfolgreich war
if ($conn->connect_error) {
    die("Verbindung fehlgeschlagen: " . $conn->connect_error);
}

// Login-Daten verarbeiten
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    // SQL-Befehl zur Überprüfung der Login-Daten
    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $storedPassword = $row["hashedPassword"];

        // Passwortüberprüfung
        if (password_verify($password, $storedPassword)) {
            echo "Login erfolgreich";
            $_SESSION["loggedin"] = true; // Sitzungsvariable setzen
            header("Location: labore.php"); // Weiterleitung zur labore.php-Seite
            exit();
        } else {
            echo "Falsches Passwort";
        }
    } else {
        echo "Benutzer nicht gefunden";
    }
}

$conn->close();
?>
