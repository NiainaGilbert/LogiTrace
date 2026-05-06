<?php
require("../../../config/db.php");
header("Content-type: application/json");

/*
* API — UPDATE DECLARATION
* Expected JSON payload: { "id": 1, "reference": "REF2", "etat": "livree" }
*/
$input = json_decode(file_get_contents('php://input'), true);
if(!$input)
    {
        http_response_code(400);
        echo json_encode(["error"=>"payload JSON attendu"]);
        exit;
    }

$id = $input['id'] ?? null;
if(!$id)
{
    http_response_code(422);
    echo json_encode(["error"=>"id requis"]);
    exit;
}

$fields = [];
$params = [];

$allowed = ['reference','expediteur','destinataire','poids','etat'];
foreach($allowed as $f)
{
    if(isset($input[$f]))
    {
        $fields[] = "$f = ?";
        $params[] = $input[$f];
    }
}

if(empty($fields))
{
    http_response_code(422);
    echo json_encode(["error"=>"aucun champ à mettre à jour"]);
    exit;
}
$params[] = $id;

try{
    $sql = "UPDATE declaration SET " . implode(", ", $fields) . " WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    echo json_encode(["success"=>true]);
}catch(Exception $e)
{
    http_response_code(500);
    echo json_encode(["error"=>"Erreur serveur","message"=>$e->getMessage()]);
}
?>
