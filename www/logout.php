<?php
// logout.php

session_start(); // Starte die Sitzung, um auf die Sitzungsvariablen zugreifen zu können

// Überprüfe, ob der Benutzer angemeldet ist
if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    // Benutzerdaten aus der Sitzung löschen
    session_unset();
    session_destroy();
    
    // Optional: Füge eine Meldung hinzu, um dem Benutzer mitzuteilen, dass er erfolgreich abgemeldet wurde
    $_SESSION['message'] = "Sie wurden erfolgreich abgemeldet.";
} else {
    // Falls der Benutzer nicht angemeldet ist, leite ihn zur index.php um oder führe andere Aktionen durch
    // ...
}

// Leite den Benutzer zur index.php um
header("Location: index.php");
exit();
?>
