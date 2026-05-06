<?php
require("../../../config/db.php");
header("Content-type: application/json");

/*
* API — READ DECLARATION
* Supports optional query param ?id= or ?reference=
*/
$id = $_GET['id'] ?? null;
$reference = $_GET['reference'] ?? null;

try{
    if($id){
        $stmt = $pdo->prepare("SELECT * FROM declaration WHERE id = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if($row)
        { 
            echo json_encode($row); 
        } 
        else
        { 
            http_response_code(404);
            echo json_encode(["error"=>"non trouvé"]);
        }
    }
    elseif($reference)
    {
        $stmt = $pdo->prepare("SELECT * FROM declaration WHERE reference = ?");
        $stmt->execute([$reference]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if($row)
        {
            echo json_encode($row);
        }
        else
        {
            http_response_code(404);
            echo json_encode(["error"=>"non trouvé"]);
        }
    }else
    {
        $stmt = $pdo->query("SELECT * FROM declaration ORDER BY created_at DESC LIMIT 200");
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($rows);
    }
}catch(Exception $e)
{ 
    http_response_code(500);
    echo json_encode(["error"=>"Erreur serveur","message"=>$e->getMessage()]);
}
?>
