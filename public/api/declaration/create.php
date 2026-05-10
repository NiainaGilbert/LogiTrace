<?php
require("../../../config/db.php");
header("Content-type: application/json");

/*
* API — CREATE DECLARATION
* Expected JSON payload: { "reference": "REF123", "type": "import/export", "statut": "en_attente" }
*/

$input = json_decode(file_get_contents('php://input'), true);
if(!$input)
{ 
    http_response_code(400);
    echo json_encode(["error"=>"payload JSON attendu"]);
    exit;
}

$reference = $input['reference'] ?? null;
$type = $input['type'] ?? null;
$statut = $input['statut'] ?? null;

if(!$reference || !$type || !$statut)
{
    http_response_code(422);
    echo json_encode(["error"=>"reference, type et statut requis"]);
    exit;
}

try{
    $stmt = $pdo->prepare("INSERT INTO declaration (reference, type, statut) VALUES (?, ?, ?)");
    $stmt->execute([$reference, $type, $statut]);
    http_response_code(201);
    echo json_encode(["success"=>true, "id"=>$pdo->lastInsertId()]);
}catch(Exception $e)
{
    http_response_code(500);
    echo json_encode(["error"=>"Erreur serveur","message"=>$e->getMessage()]);
}
?>
