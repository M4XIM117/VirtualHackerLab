<?php
// Verbindung zur Datenbank herstellen
$hostname = "localhost";
$username = "root";
$password = "";
$database = "vhl";
$port = 3306;

$conn = mysqli_connect($hostname, $username, $password, $database, $port);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Funktion zum Überprüfen, ob ein String mit einem bestimmten Teilstring endet
function endsWith($haystack, $needle) {
    $length = strlen($needle);
    if ($length == 0) {
        return true;
    }
    return (substr($haystack, -$length) === $needle);
}

// Funktion zum Hashen des Passworts
function hashPassword($password) {
    return password_hash($password, PASSWORD_DEFAULT);
}

// Fehler-Array initialisieren
$errors = [];

// Formulardaten verarbeiten
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirmPassword = $_POST["confirmPassword"];

    // Name-Validierung
    if (!preg_match('/^[a-zA-Z0-9]+$/', $name)) {
        $errors["name"] = "Der Name darf nur aus Buchstaben und Zahlen bestehen.";
    } elseif (strlen($name) > 15) {
        $errors["name"] = "Der Name darf nicht länger als 15 Zeichen sein.";
    }

    // E-Mail-Validierung
    if (!strpos($email, "@")) {
        $errors["email"] = "Die E-Mail-Adresse muss ein @ enthalten.";
    } elseif (!endsWith($email, ".com") && !endsWith($email, ".de")) {
        $errors["email"] = "Die E-Mail-Adresse darf nur mit .com oder .de enden.";
    }

    // Passwort-Validierung
    if (!preg_match('/\d/', $password)) {
        $errors["password"] = "Das Passwort muss mindestens eine Ziffer enthalten.";
    } elseif (!preg_match('/[!@#$%^&*(),.?":{}|<>]/', $password)) {
        $errors["password"] = "Das Passwort muss mindestens ein Sonderzeichen enthalten.";
    } elseif (strlen($password) < 8) {
        $errors["password"] = "Das Passwort muss mindestens 8 Zeichen lang sein.";
    } elseif (!preg_match('/[a-z]/', $password) || !preg_match('/[A-Z]/', $password)) {
        $errors["password"] = "Das Passwort muss aus Groß- und Kleinbuchstaben bestehen.";
    }

    // Passwort-Bestätigung
    if ($password !== $confirmPassword) {
        $errors["confirmPassword"] = "Die Passwörter stimmen nicht überein.";
    }

    // Wenn keine Fehler vorliegen, Benutzer in die Datenbank einfügen
    if (empty($errors)) {
        // Hashen des Passworts
        $hashedPassword = hashPassword($password);

        // SQL-Query zum Einfügen des Benutzers
        $sql = "INSERT INTO users (username, email, hashed_password) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $name, $email, $hashedPassword);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            session_start();
            $_SESSION["username"] = $name;
            header("Location: success.php");
            exit();
        } else {
            echo "Fehler beim Einfügen des Benutzers: " . $stmt->error;
        }
        $stmt->close();
    }
}

// Verbindung zur Datenbank schließen
$conn->close();
?>