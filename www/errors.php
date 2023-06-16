<?php
/**
 * Summary of endsWith
 * @param mixed $haystack
 * @param mixed $needle
 * @return bool
 */
function endsWith($haystack, $needle) {
    $length = strlen($needle);
    if ($length == 0) {
        return true;
    }
    return substr($haystack, -$length) === $needle;
}


/**
 * Summary of displayError
 * @param mixed $errors
 * @param mixed $field
 * @return void
 */
function displayError(&$errors, $field) {
    if (isset($errors[$field])) {
        echo '<small class="text-danger">' . $errors[$field] . '</small>';
    }
}


$errors = [];

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
    } elseif (strlen($name) < 6) {
        $errors["name"] = "Der Name darf nicht kürzer als 6 Zeichen sein.";
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
}
?>
