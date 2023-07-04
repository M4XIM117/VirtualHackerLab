<?php
session_start(); // Starte die Sitzung, um auf die Sitzungsvariablen zugreifen zu können

// Überprüfe, ob der Benutzer angemeldet ist
$loggedIn = isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true;

// Weiterleitung zur Login-Seite oder Anzeige einer Fehlermeldung, wenn der Benutzer nicht angemeldet ist
if (!$loggedIn) {
    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="de">

<head>
    <title>Virtual Hacker's Lab</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="description"
        content="Virtual Hacker's Lab ist eine interaktive Plattform, die virtuelle Hacking Labs für das Lernen und Üben von Ethical Hacking und Cyber-Security bietet. Entdecke eine breite Palette von Herausforderungen, um deine Fähigkeiten zu verbessern und echte Szenarien zu simulieren. Tauche ein in die Welt des Hackings und erlange wertvolles Wissen für eine Karriere in der Cyber-Security.">
    <meta name="keywords"
        content="Virtual Hacker's Lab, virtuelle Hacking Labs, Ethical Hacking, Cyber-Security, Hacking Herausforderungen, Lernen, Üben, Cyber-Security-Versuche">
    <meta name="author" content="Virtual Hacker's Lab Team">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="icon" href="favicon.ico" type="images/x-icon">
    <link rel="stylesheet" href="fonts/fontawesome/css/all.min.css" />
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/aos.css">
    <link rel="stylesheet" href="css/all.min.css">
    <link rel="stylesheet" href="css/xterm.css">
    <!-- MAIN CSS -->
    <link rel="stylesheet" href="css/style.css">
    <style>
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        
        .site-footer {
            margin-top: auto;
        }
    </style>
</head>

<body data-spy="scroll" data-target="#navbarNav" data-offset="50">

    <!-- MENU BAR -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand" href="index.php">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-lg-auto">
                    <li class="nav-item">
                        <a href="index.php" class="nav-link">Über uns</a>
                    </li>
                    <li class="nav-item">
                        <a href="labore.php" class="nav-link">Labore</a>
                    </li>
                    <?php if ($loggedIn): ?>
                        <li class="nav-item">
                            <a href="logout.php" class="nav-link">Abmelden</a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a href="#" class="nav-link" data-toggle="modal" data-target="#registerModal">Registrieren</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link" data-toggle="modal" data-target="#loginModal"><i
                                    class="fas fa-sign-in-alt"></i> Anmelden</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Modal für Registrierung -->
    <div class="modal fade" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="registerModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="registerModalLabel">Registrieren</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <!-- Registrierungsformular -->
                <div class="modal-body">
                    <form action="registration.php" method="POST">
                        <div class="form-group">
                            <label for="username">Benutzername</label>
                            <input class="form-control" type="name" name="username" placeholder="Benutzername"
                                autocomplete="off" required>
                        </div>
                        <div class="form-group">
                            <label for="email">E-Mail</label>
                            <input class="form-control" type="email" name="email" placeholder="E-Mail"
                                autocomplete="email" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Passwort</label>
                            <input class="form-control" type="password" name="password" placeholder="Passwort"
                                autocomplete="off" required>
                        </div>
                        <div class="form-group">
                            <label for="confirmPassword">Passwort bestätigen</label>
                            <input class="form-control" type="password" name="confirmPassword"
                                placeholder="Passwort bestätigen" autocomplete="off" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Registrieren</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id="success-message" class="popup"></div>



    <!-- Login-Modal -->
    <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="loginModalLabel">Login</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <!-- Login-Formular hier einfügen -->
                    <form action="login.php" method="POST">
                        <div class="form-group">
                            <label for="email">E-Mail</label>
                            <input class="form-control" type="email" name="email" placeholder="E-Mail eingeben"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="password">Passwort</label>
                            <input class="form-control" type="password" name="password" placeholder="Passwort" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Anmelden</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

<!-- LABORE -->
<section class="class section" id="class">
    <div class="container">
        <div class="row d-flex align-items-stretch justify-content-stretch">
            <div class="col-lg-12 col-12 text-center mb-5">
                <h6>Erreiche deine Ziele</h6>
                <h2>Unsere Labore</h2>
            </div>
            <div class="col-lg-4 col-md-6 col-12" id="log4shell-card">
                <div class="class-thumb">
                    <img src="images/labs/lab-easy.jpg" class="img-lab1" alt="Labor-1">
                    <div class="class-info">
                        <h3 class="mb-1">Log4Shell</h3>
                        <span><strong>Level</strong> - easy</span>
                        <p class="mt-3">Schädlichen Code über Log-Nachrichten einschleusen und ausführen, um Systeme zu kompromittieren.</p>
                        <button class="custom-button webshell" onclick="window.location.href = 'webshell.html'">Labor starten</button>
                    </div>
                </div>
            </div>
            <div class="mt-5 mt-lg-0 mt-md-0 col-lg-4 col-md-6 col-12" id="pwcracking-card">
                <div class="class-thumb">
                    <img src="images/labs/lab-middle.jpg" class="img-lab2" alt="Labor-2">
                    <div class="class-info">
                        <h3 class="mb-1">Password-Cracking & SQL Injection</h3>
                        <span><strong>Level</strong> - middle</span>
                        <p class="mt-3">Online und Offline Brute Force sowie Passwort-Hashes mit SQL-injection herausfinden</p>
                        <button class="custom-button log4shell" onclick="window.location.href = 'log4shell.html'">Labor starten</button>
                    </div>
                </div>
            </div>
            <div class="mt-5 mt-lg-0 col-lg-4 col-md-6 col-12" id="webshell-card">
                <div class="class-thumb">
                    <img src="images/labs/lab-hard.jpg" class="img-lab3" alt="Class">
                    <div class="class-info">
                        <h3 class="mb-1">Webshell</h3>
                        <span><strong>Level</strong> - hard</span>
                        <p class="mt-3">Durch Skripteinschleusung über Web-Upload in einen Server gelangen, auf diesen zugreifen und Kontrolle ausüben</p>
                        <button class="custom-button log4j" onclick="window.location.href = 'pwcracking.html'">Labor starten</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

    <!-- FOOTER -->
    <footer class="site-footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-5">
                    <p class="footer-text">Virtual Hacker's Lab &copy; 2023</p>
                </div>
                <div class="col-lg-5 col-md-7 col-12">
                    <ul class="footer-menu">
                        <li><a href="aboutproject.html">Über uns</a></li>
                        <li><a href="labore.php">Labore</a></li>
                        <li><a href="#" data-toggle="modal" data-target="#registerModal">Registrieren</a></li>
                        <li><a href="#" data-toggle="modal" data-target="#loginModal">Anmelden</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>


    <!-- SCRIPTS -->
    <script src="js/script.js"></script>
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/aos.js"></script>
    <script src="js/smoothscroll.js"></script>
    <script src="js/custom.js"></script>
</body>

</html>