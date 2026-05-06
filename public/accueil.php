<?php

// Établissement de la session
session_start();

if (!isset($_SESSION['logged'])) {
    header("Location: login.html");
    exit();
}

$user = $_SESSION;
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://cdn.boxicons.com/3.0.8/fonts/basic/boxicons.min.css" rel="stylesheet">
    <script src="../src/navigator.js" defer></script>
    <link rel="stylesheet" href="">
</head>
<body>

<div class="Dashboard">
    <aside class="NavBar">
        <h1>LogiTrace</h1>
        <h3><?= htmlspecialchars($user['role']) ?></h3>
        <ul>
            <li class="active" data-page="dashboard">Tableau de Bord</li>
            <li data-page="utilisateur">Gestion Utilisateurs</li>
            <li data-page="stock">Gestion des Colies</li>
            <li data-page="operation">Opérations</li>
        </ul>
        <button class="incident-btn"><i class="bx bx-alert-triangle"></i>Signaler un incident</button>
        <button><i class="bx bx-door-open"></i><a href="logout.php">Déconnexion</a></button>
    </aside>
    
    <header class="Head">
        <input type="text" placeholder="Recherche">
        <p><?= htmlspecialchars($user['nom']) ?></p>
    </header>



    <main class="Grid" id="main-content">

    <!-- Chargement des pages -->


    </main>
</div>

</body>
</html>
