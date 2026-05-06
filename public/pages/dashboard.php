<?php
session_start();

if (!isset($_SESSION['logged'])) {
    header("Location: login.html");
    exit();
}

$user = $_SESSION;
?>

        <div class="card small"><i class="bx bx-container"></i><h3>Colies</h3><p>42</p></div>
        <div class="card small"><i class="bx bx-user"></i><h3>Utilisateurs</h3><p>133</p></div>
        <div class="card small"><i class="bx bx-road"></i><h3>Déclaration</h3><p>123</p></div>
        <div class="card incident"><i class="bx bx-alert-circle"></i><h3>Refudée</h3><p>6</p></div>
        <div class="card map">
            <iframe 
                src="https://www.marinetraffic.com/en/ais/embed/zoom:5/centery:-18/centerx:47/maptype:1/shownames:true/mmsi:0/shipid:0/fleet:/fleet_id:/vtypes:/showmenu:false/remember:false"
                width="100%" 
                height="100%" 
                frameborder="0">
            </iframe>
        </div>
        <div class="card alerts">
            <div class="alert-item">Avion arrivé</div>
            <div class="alert-item">Bateua arrivé</div>
        </div>
        <div class="card ">
            Rapports du jour
        </div>