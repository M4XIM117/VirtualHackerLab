<?php session_start(); ?>
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
</head>

<body data-spy="scroll" data-target="#navbarNav" data-offset="50">

  <!-- MENU BAR -->
  <nav class="navbar navbar-expand-lg fixed-top">
    <div class="container">
      <a class="navbar-brand" href="#">
      </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-lg-auto">
          <li class="nav-item">
            <a href="aboutproject.html" class="nav-link">Über uns</a>
          </li>
          <li class="nav-item">
            <a href="labore.php" class="nav-link" data-toggle="modal" data-target="#messageModal">Labore</a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link " data-toggle="modal" data-target="#registerModal">Registrieren</a>
          </li>
          <?php
          if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
            // Benutzer ist eingeloggt
            echo '
                <li class="nav-item">
                    <a href="#" class="nav-link" data-toggle="modal" data-target="#loginModal"><i class="fa fa-sign-out"></i> Abmelden</a>
                </li>';
          } else {
            // Benutzer ist nicht eingeloggt
            echo '
                <li class="nav-item">
                    <a href="#" class="nav-link" data-toggle="modal" data-target="#loginModal"><i class="fas fa-sign-in-alt"></i> Anmelden</a>
                </li>';
          }
          ?>
        </ul>
      </div>
    </div>
  </nav>

<!-- Modal für Zugriff-Message -->
<div class="modal fade" id="messageModal" tabindex="-1" role="dialog" aria-labelledby="messageModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
      <h5 class="modal-title" id="messageModalLabel">Zugriff erhalten</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
          </button>
      </div>

        <!-- Zugriffsmessage -->
      <div class="modal-body">
        <div class="form-group">
          <label for="message">Um Zugriff auf diese Seite zu erhalten, müssen Sie sich erst registrieren oder anmelden.</label>
        </div>
      </div>
    </div>
  </div>  
</div>

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
              <input class="form-control" type="name" name="username" placeholder="Benutzername" autocomplete="off"
                required>
            </div>
            <div class="form-group">
              <label for="email">E-Mail</label>
              <input class="form-control" type="email" name="email" placeholder="E-Mail" autocomplete="email" required>
            </div>
            <div class="form-group">
              <label for="password">Passwort</label>
              <input class="form-control" type="password" name="password" placeholder="Passwort" autocomplete="off"
                required>
            </div>
            <div class="form-group">
              <label for="confirmPassword">Passwort bestätigen</label>
              <input class="form-control" type="password" name="confirmPassword" placeholder="Passwort bestätigen"
                autocomplete="off" required>
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
              <input class="form-control" type="email" name="email" placeholder="E-Mail eingeben" required>
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
    <?php if (isset($_SESSION["error"])) { ?>
        <div id="overlay">
            <div id="overlay-content">
                <h2><?php echo $_SESSION["error"]; ?></h2>
                <p>Um Zugriff auf diese Seite zu erhalten, müssen Sie sich erst registrieren oder anmelden.</p>
                <a href="#" class="nav-link " data-toggle="modal" data-target="#registerModal">Registrieren</a>
                <a href="#" class="nav-link" data-toggle="modal" data-target="#loginModal">Anmelden</a>
            </div>
        </div>
        <?php unset($_SESSION["error"]); ?>
    <?php } ?>

  <!-- HERO -->
  <section class="hero d-flex flex-column justify-content-center align-items-center" id="home">
    <div class="bg-overlay"></div>
    <div class="container">
      <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto col-12">
          <div class="hero-text mt-5 text-center">
            <h3 data-aos="fade-up" data-aos-delay="300" style="color: white;">Stärke deine Cyberabwehr, schütze deine digitale Welt.</h6>
            <h1 class="text-white" data-aos="fade-up" data-aos-delay="500">Lerne, verteidige und erhebe dich in der Welt
              der Cybersicherheit mit VHL!</h1>
              <button href="aboutproject.html" class="neon-button" data-aos="fade-up" data-aos-delay="700">Erfahre mehr</button>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- SCRIPTS -->
  <script src="js/jquery.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/aos.js"></script>
  <script src="js/smoothscroll.js"></script>
  <script src="js/custom.js"></script>


  <script>
        // Überprüfen, ob der Benutzer eingeloggt ist
        <?php if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) { ?>
            // Weiterleitung zur labore.php-Seite, wenn der Benutzer eingeloggt ist
            window.location.href = "labore.php";
        <?php } else { ?>
            // Anzeigen des Overlays, wenn der Benutzer nicht eingeloggt ist
            document.getElementById("overlay").style.display = "block";
        <?php } ?>
    </script>
</body>

</html>