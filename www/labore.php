<?php
session_start();

// Überprüfen, ob der Benutzer eingeloggt ist
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    // Benutzer ist nicht eingeloggt, Weiterleitung zur index.php-Seite mit Fehlermeldung
    $_SESSION["error"] = "Bitte registrieren oder anmelden, um Zugriff auf diese Seite zu erhalten.";
    header("Location: index.php");
    exit;
}
?>


<!DOCTYPE html>
<html lang="de">

<head>
    <title>Virtual Hacker's Lab</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">

    <!-- für SEO: muss noch ausgefüllt werden -->
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="fonts/fontawesome/css/all.min.css" />
    <link rel="stylesheet" href="css/aos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <!-- MAIN CSS -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" href="favicon.ico" type="images/x-icon">
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
                    <li class="nav-item">
                        <a href="#" class="nav-link " data-toggle="modal" data-target="#registerModal">Registrieren</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link" data-toggle="modal" data-target="#loginModal"><i
                                class="fas fa-sign-in-alt"></i> Anmelden</a>
                    </li>
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
        <div class="row">
            <div class="col-lg-12 col-12 text-center mb-5">
                <h6>Erreiche deine Ziele</h6>
                <h2>Unsere Labore</h2>
            </div>
            <div class="col-lg-4 col-md-6 col-12">
                <div class="class-thumb">
                    <img src="images/labs/lab-easy.jpg" class="img-fluid" alt="Class">
                    <div class="class-info">
                        <h3 class="mb-1">Webshell</h3>
                        <span><strong>Level</strong> - easy</span>
                        <p class="mt-3">Lorem ipsum dolor sit amet, consectetur adipiscing</p>
                        <button class="custom-button webshell" onclick="window.location.href = 'webshell.html'">Labor starten</button>
                    </div>
                </div>
            </div>
            <div class="mt-5 mt-lg-0 mt-md-0 col-lg-4 col-md-6 col-12">
                <div class="class-thumb">
                    <img src="images/labs/lab-middle.jpg" class="img-fluid" alt="Class">
                    <div class="class-info">
                        <h3 class="mb-1">Jog4Shell</h3>
                        <span><strong>Level</strong> - middle</span>
                        <p class="mt-3">Lorem ipsum dolor sit amet, consectetur adipiscing</p>
                        <button class="custom-button log4shell" onclick="window.location.href = 'log4shell.html'">Labor starten</button>
                    </div>
                </div>
            </div>
            <div class="mt-5 mt-lg-0 col-lg-4 col-md-6 col-12">
                <div class="class-thumb">
                    <img src="images/labs/lab-hard.jpg" class="img-fluid" alt="Class">
                    <div class="class-info">
                        <h3 class="mb-1">Password-Cracking & SQL Injection</h3>
                        <span><strong>Level</strong> - hard</span>
                        <p class="mt-3">Lorem ipsum dolor sit amet, consectetur adipiscing</p>
                        <button class="custom-button log4j" onclick="window.location.href = 'pwcracking.html'">Labor starten</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>


    <!-- FOOTER -->
    <footer class="site-footer">
        <div class="container">
            <div class="row">
                <div class="ml-auto col-lg-4 col-md-5">
                    <p class="copyright-text">Copyright &copy; 2023 vhl
                        <br>Projekt: VHL</a>
                    </p>
                </div>
                <div class="d-flex justify-content-center mx-auto col-lg-5 col-md-7 col-12">
                    <p class="mr-4">
                        <i class="fa fa-envelope-o mr-1"></i>
                        <a href="#">info@vhl.de</a>
                    </p>
                </div>
            </div>
        </div>
    </footer>

    <!-- SCRIPTS -->
    <script src="js/script.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/aos.js"></script>
    <script src="js/smoothscroll.js"></script>
    <script src="js/custom.js"></script>
</body>

</html>