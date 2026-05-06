<?php
require("../../../config/db.php");
header("Content-type: application/json");

/*
* API — CREATE DECLARATION
* Expected JSON payload: { "reference": "REF123", "expediteur": "Nom", "destinataire": "Nom", "poids": 100, "etat": "en_attente" }
*/

$input = json_decode(file_get_contents('php://input'), true);
if(!$input)
{ 
    http_response_code(400);
    echo json_encode(["error"=>"payload JSON attendu"]);
    exit;
}

$reference = $input['reference'] ?? null;
$expediteur = $input['expediteur'] ?? null;
$destinataire = $input['destinataire'] ?? null;
$poids = $input['poids'] ?? null;
$etat = $input['etat'] ?? 'en_attente';

if(!$reference || !$expediteur)
{
    http_response_code(422);
    echo json_encode(["error"=>"reference et expediteur requis"]);
    exit;
}

try{
    $stmt = $pdo->prepare("INSERT INTO declaration (reference, expediteur, destinataire, poids, etat, created_at) VALUES (?, ?, ?, ?, ?, NOW())");
    $stmt->execute([$reference, $expediteur, $destinataire, $poids, $etat]);
    http_response_code(201);
    echo json_encode(["success"=>true, "id"=>$pdo->lastInsertId()]);
}catch(Exception $e){ http_response_code(500); echo json_encode(["error"=>"Erreur serveur","message"=>$e->getMessage()]); }
?>
