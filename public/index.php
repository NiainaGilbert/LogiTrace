<?php
// Page d'accueil : Suivi de dédouanement
?>
<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Suivi Dédouanement — Accueil</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:ital,wght@0,300;0,400;0,500;1,300&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/index.css">
</head>
<body>

  <!-- Particules décoratives -->
  <div class="bg-particles" aria-hidden="true">
    <span class="particle p1"></span>
    <span class="particle p2"></span>
    <span class="particle p3"></span>
    <span class="particle p4"></span>
  </div>

  <header class="site-header">
    <div class="container header-inner">
      <a class="brand" href="index.php">
        <span class="brand-icon">⬡</span>
        LogiTrace
      </a>
      <nav class="main-nav">
        <a href="login.html" class="nav-link">Se connecter</a>
        <a href="register.html" class="btn btn-primary">S'inscrire <span class="btn-arrow">→</span></a>
      </nav>
    </div>
  </header>

  <main>
    <section class="hero">
      <div class="container hero-inner">

        <div class="hero-content">

          <h1>Suivez vos déclarations<br><em>en temps réel</em></h1>
          <p class="lead">Consultez l'état, l'historique et recevez des notifications liées à vos opérations d'import/export à Madagascar.</p>

        </div>


      </div>
    </section>

    <!-- Section fonctionnalités -->
    <section class="features" id="features">
      <div class="container">
        <div class="section-label">Pourquoi LogiTrace ?</div>
        <h2 class="section-title">Tout ce dont vous avez besoin</h2>
        <div class="features-grid">
          <div class="feature-card">
            <h3>Suivi en temps réel</h3>
            <p>Recevez des mises à jour instantanées sur l'avancement de vos déclarations à chaque étape du processus douanier.</p>
          </div>
          <div class="feature-card">
            <h3>Notifications intelligentes</h3>
            <p>Alertes par email ou SMS dès qu'une action est requise ou qu'un statut change sur vos dossiers.</p>
          </div>
          <div class="feature-card">
            <h3>Historique complet</h3>
            <p>Accédez à l'intégralité de l'historique de chaque opération, avec les documents associés.</p>
          </div>
          <div class="feature-card">
            <h3>Sécurité garantie</h3>
            <p>Vos données sont chiffrées et protégées. Accès sécurisé à votre espace personnel en tout temps.</p>
          </div>
        </div>
      </div>
    </section>

  </main>

  <footer class="site-footer">
    <div class="container footer-inner">
      <p class="brand brand-foot"><span class="brand-icon">⬡</span> LogiTrace &mdash; &copy; <?php echo date('Y'); ?> Tous droits réservés.</p>
      <nav class="footer-nav">
        <a href="pages/utilisateur.php">Aide</a>
        <a href="#">Mentions légales</a>
        <a href="#">Contact</a>
      </nav>
    </div>
  </footer>

</body>
</html>