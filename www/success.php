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
     <link rel="stylesheet" href="css/stylewebshell.css">
     <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <!-- MENU BAR -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
          <a class="navbar-brand" href="index.html">
          </a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-lg-auto">
              <li class="nav-item">
                <a href="#" class="nav-link smoothScroll">Über uns</a>
              </li>
              <li class="nav-item">
                <a href="labore.html" class="nav-link">Labore</a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link smoothScroll" data-toggle="modal" data-target="#registerModal">Registrieren</a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link smoothScroll" data-toggle="modal" data-target="#loginModal"><i class="fas fa-sign-in-alt"></i></a>
              </li>
              <div class="user-greeting">
                <?php
                // Benutzername aus der Session abrufen und anzeigen
                session_start();
                if (isset($_SESSION["username"])) {
                    $username = $_SESSION["username"];
                    echo "Hallo, $username!";
                }
                ?>
            </div>
            </ul>
          </div>
        </div>
      </nav>

    <section class="banner">
        <div class="container">
            <h2>Erfolgreich registriert!</h2>
            <p>Vielen Dank für die Registrierung.</p>
        </div>
    </section>

    <section class="features">
        <div class="container">
            <h3>Weitere Funktionen</h3>
            <p>Weitere Funktionen der Website.</p>
        </div>
    </section>

    <!-- FOOTER -->
<footer class="site-footer">
    <div class="container">
        <div class="row">
            <div class="ml-auto col-lg-4 col-md-5">
                <p class="copyright-text">Copyright &copy; 2023 vhl
                    <br>Projekt: VHL</a></p>
                </div>
                <div class="d-flex justify-content-center mx-auto col-lg-5 col-md-7 col-12">
                    <p class="mr-4">
                        <i class="fa fa-envelope-o mr-1"></i>
                        <a href="#">test@vhl.de</a>
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
