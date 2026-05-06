<?php
require("../../../config/db.php");
header("Content-type: application/json");

/*
* API — DELETE DECLARATION
* Expects JSON {"id": 1} or query param ?id=1
*/

$input = json_decode(file_get_contents('php://input'), true);
$id = $input['id'] ?? ($_GET['id'] ?? null);
if(!$id){ 
    http_response_code(422);
    echo json_encode(["error"=>"id requis"]);
    exit;
}

try{
    $stmt = $pdo->prepare("DELETE FROM declaration WHERE id = ?");
    $stmt->execute([$id]);
    echo json_encode(["success"=>true]);
}catch(Exception $e){ http_response_code(500); echo json_encode(["error"=>"Erreur serveur","message"=>$e->getMessage()]); }
?>
