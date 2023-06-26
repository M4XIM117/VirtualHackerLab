<?php
session_start();
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
<!DOCTYPE html>
<html lang="de">

<head>
  <title>Virtual Hacker's Lab</title>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=Edge">
  <!-- SEO: muss noch ausgefüllt werden -->
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
      <a class="navbar-brand" href="#">
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

  <!-- HERO -->
  <section class="hero d-flex flex-column justify-content-center align-items-center" id="home">
    <div class="bg-overlay"></div>
    <div class="container">
      <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto col-12">
          <div class="hero-text mt-5 text-center">
            <h6 data-aos="fade-up" data-aos-delay="300">Stärke deine Cyberabwehr, schütze deine digitale Welt.</h6>
            <h1 class="text-white" data-aos="fade-up" data-aos-delay="500">Lerne, verteidige und erhebe dich in der Welt
              der Cybersicherheit mit VHL!</h1>
            <a href="#feature" class="btn custom-btn mt-3" data-aos="fade-up" data-aos-delay="600">Lege los</a>
            <a href="#about" class="btn custom-btn bordered mt-3" data-aos="fade-up" data-aos-delay="700">Erfahre
              mehr</a>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- FEATURE -->
  <section class="feature" id="feature">
    <div class="container">
      <div class="row">
        <div class="d-flex flex-column justify-content-center ml-lg-auto mr-lg-5 col-lg-5 col-md-6 col-12">
          <h2 class="mb-3 text-white" data-aos="fade-up">Neu bei uns?</h2>
          <h6 class="mb-4 text-white" data-aos="fade-up">Schütze deine Daten und Systeme mit VHL! Werde ein ethischer
            Hacker und verteidige dich gegen mögliche Angriffe. Melde dich noch heute an und tauche in die spannende
            Welt der Cybersicherheit ein.</h6>
          <p data-aos="fade-up" data-aos-delay="200"><strong>Hinweis: </strong>Ethical Hacking sollte immer in
            Übereinstimmung mit den geltenden Gesetzen und Vorschriften durchgeführt werden. VHL fördert ausschließlich
            ethisches Hacking zu Lernzwecken und ermutigt nicht zu illegalen Aktivitäten.</p>
          <a href="#" class="btn custom-btn bg-color mt-3" data-aos="fade-up" data-aos-delay="300" data-toggle="modal"
            data-target="#membershipForm">Heute noch Mitglied werden</a>
        </div>
        <div class="mr-lg-auto mt-3 col-lg-4 col-md-6 col-12">
          <div class="about-working-hours">
            <div>
              <h2 class="mb-4 text-white" data-aos="fade-up" data-aos-delay="500">Unser Versprechen an dich</h2>
              <strong class="d-block" data-aos="fade-up" data-aos-delay="600">Experimentiere in einer sicheren Umgebung
                mit realistischen Szenarien</strong>
              <strong class="mt-3 d-block" data-aos="fade-up" data-aos-delay="700">Lerne, wie Hacker vorgehen und welche
                Schwachstellen sie ausnutzen</strong>
              <strong class="mt-3 d-block" data-aos="fade-up" data-aos-delay="700">Lerne entsprechende Abwehrmaßnahmen
                und Gegenstrategien kennenm, um dich effektiv zu schützen</strong>
              <strong class="mt-3 d-block" data-aos="fade-up" data-aos-delay="700">Halte dich durch unsere regelmäßig
                aktualisierten Inhalte auf dem neusten Stand</strong>
              <strong class="mt-3 d-block" data-aos="fade-up" data-aos-delay="700">Bekomme ein umfassendes Verständnis
                für Cybersicherheit und Ethical Hacking vermittelt</strong>
            </div>
          </div>
        </div>
      </div>
    </div>
    </div>
  </section>

  <!-- DETAIL -->
  <section class="detail">
    <div class="container">
      <div class="row">
        <div class="detail-item">
          <span><i class="fas fa-tablet-alt"></i></span>
          <h2>Responsive Design</h2>
          <div class="line"></div>
          <p class="detail-text">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor
            invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua.
            At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus
            est Lorem ipsum dolor sit amet.
          </p>
        </div>

        <div class="detail-item">
          <span><i class="fab fa-html5"></i></span>
          <h2>Responsive Design</h2>
          <div class="line"></div>
          <p class="detail-text">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor
            invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua.
            At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus
            est Lorem ipsum dolor sit amet.
          </p>
        </div>

        <div class="detail-item">
          <span><i class="far fa-bell"></i></span>
          <h2>Responsive Design</h2>
          <div class="line"></div>
          <p class="detail-text">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor
            invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua.
            At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus
            est Lorem ipsum dolor sit amet.
          </p>
        </div>
      </div>
    </div>
  </section>

  <!-- ABOUT -->
  <section class="about section" id="about">
    <div class="container">
      <div class="row">
        <div class="mt-lg-5 mb-lg-0 mb-4 col-lg-5 col-md-10 mx-auto col-12">
          <h2 class="mb-4" data-aos="fade-up" data-aos-delay="300">Hi, wir sind VHL</h2>
          <p data-aos="fade-up" data-aos-delay="400">Bei VHL geht es darum, dir die notwendigen Fähigkeiten
            beizubringen, um sich gegen Hackereingriffe zu schützen.</p>
          <p data-aos="fade-up" data-aos-delay="500">Unser interaktives Lernprogramm bietet eine Kombination aus
            theoretischem Wissen und praktischen Labors, um dir ein umfassendes Verständnis für <strong
              style="color: var(--primary-color);">Cybersicherheit</strong> und <strong
              style="color: var(--primary-color);">Ethical Hacking</strong> zu vermitteln.</p>
        </div>
        <div class="ml-lg-auto col-lg-3 col-md-6 col-12" data-aos="fade-up" data-aos-delay="700">
          <div class="home-thumb">
            <img src="images/home/who-we-are.jpg" class="img-fluid" alt="Schloss">
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- CONTACT -->
  <section class="contact section" id="contact">
    <div class="container">
      <div class="row">

        <div class="ml-auto col-lg-5 col-md-6 col-12">
          <h2 class="mb-4 pb-2" data-aos="fade-up" data-aos-delay="200">Du kannst gerne alles fragen</h2>

          <form action="#" method="post" class="contact-form webform" data-aos="fade-up" data-aos-delay="400"
            role="form">
            <input type="text" class="form-control" name="cf-name" placeholder="Name">

            <input type="email" class="form-control" name="cf-email" placeholder="E-Mail">

            <textarea class="form-control" rows="5" name="cf-message" placeholder="Nachricht"></textarea>

            <button type="submit" class="form-control" id="submit-button" name="submit">Nachricht abschicken</button>
          </form>
        </div>

        <div class="mx-auto mt-4 mt-lg-0 mt-md-0 col-lg-5 col-md-6 col-12">
          <h2 class="mb-4" data-aos="fade-up" data-aos-delay="600">Wie du uns <span>erreichen kannst</span></h2>
          <div class="address" data-aos="fade-up" data-aos-delay="400">
            <i class="fa-brands fa-instagram"></i>
            <h5>auf Social Media</h5>
            <p><a href="#">zum Instagram Account</a></p>
          </div>

          <div class="email" data-aos="fade-up" data-aos-delay="500">
            <i class="fa fa-envelope"></i>
            <h5>per E-Mail</h5>
            <p>info@vhl.de</p>
          </div>

          <div class="phone" data-aos="fade-up" data-aos-delay="600">
            <i class="fa fa-discord"></i>
            <h5>im Discord Channel</h5>
            <p><a href="#">zum Channel</a></p>
          </div>

        </div>

      </div>
    </div>
  </section>

  <!-- FOOTER -->
  <footer class="site-footer">
    <div class="container">
      <div class="row">

        <div class="ml-auto col-lg-4 col-md-5">
          <p class="copyright-text">Copyright &copy; 2023 Jahresprojekt
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
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/js/bootstrap.min.js"></script>
  <script src="js/jquery.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/aos.js"></script>
  <script src="js/smoothscroll.js"></script>
  <script src="js/custom.js"></script>
</body>

</html>