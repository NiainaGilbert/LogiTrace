<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Chauffeur</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/utilisateur.css">
    <link href="https://cdn.boxicons.com/3.0.8/fonts/basic/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="">
</head>
<body>

<div class="Dashboard">
    <aside class="NavBar">
        <h1>Taxi-be</h1>
        <h3>ANTANANARIVO ADMIN</h3>
        <ul>
            <li>Tableau de Bord</li>
            <li>Gestion de Réseau</li>
            <li class="active">Flotte & Chauffeurs</li>
            <li>Opérations</li>
        </ul>
        <button class="incident-btn"><i class="bx bx-alert-triangle"></i>Signaler un incident</button>
        <button><i class="bx bx-door-open"></i>Déconnexion</button>
    </aside>
    
    <header class="Head">
        <input type="text" placeholder="Recherche">
        <p>User</p>
    </header>
    <main class="profil-grid">

        <div class="card profil">
            <div class="profil-top">
                <img src="https://i.pravatar.cc/100" class="avatar">
                <div>
                    <h2>Rakoto Jean</h2>
                    <p class="role">Operateur</p>  <!--Role-->
                    <p class="meta">Membre depuis Janv 2021</p>
                </div>
            </div>
        </div>

        <div class="card performance">
            <h3>Score de confiance</h3>
            <h1>98.4%</h1>

            <div class="stats">
                <div>
                    <p>Trajets Totaux</p>
                    <h4>1,248</h4>
                </div>
                <div>
                    <p>Heures de Service</p>
                    <h4>4,120h</h4>
                </div>
            </div>

            <div class="punctuality">
                Ponctualité : <strong>94%</strong>
            </div>
        </div>

        <div class="card history">
            <h3>Historique des Actions</h3>

            <div class="trip">
                <span>12 Oct 2023</span>
                <span>Nom colis</span>
                <span class="ok">Terminé</span>
                <span>18/18</span>
            </div>

            <div class="trip">
                <span>12 Oct 2023</span>
                <span>Nom colis</span>
                <span class="ok">Terminé</span>
                <span>18/18</span>
            </div>

            <div class="trip">
                <span>11 Oct 2023</span>
                <span>Nom colis</span>
                <span class="late">Retard</span>
                <span>16/18</span>
            </div>
        </div>

        <div class="card extra">
            <h3>Conformité & Santé</h3>

            <div class="status ok">Examen médical OK</div>
            <div class="status">Assurance à jour</div>
            <div class="status warn">Infraction mineure</div>
        </div>

    </main>
</div>

</body>
</html>