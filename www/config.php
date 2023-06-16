<?php
// Datenbankverbindungsinformationen
$hostname = 'localhost';  // Server-Hostname
$username = 'root';       // Benutzername (Standardmäßig 'root' bei XAMPP)
$password = '';           // Passwort (Standardmäßig leer bei XAMPP)
$database = 'vhl';  // Datenbankname
$conn = mysqli_connect($hostname, $username, $password, $database);
if (!$conn) {
    die('Could not Connect MySql Server: ' . mysqli_error($conn));
}
?>
