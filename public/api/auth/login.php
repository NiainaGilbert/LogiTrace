<?php

/**
 * API — LOGIN
 * Méthode : POST
 *
 */

require("../../../config/db.php");
header("Content-type: application/json");
session_start();


$data = json_decode(file_get_contents("php://input"), true);


$email = $data['email'] ?? null;
$passwd = $data['password'] ?? null;

//recuperation des donnees du db
$rqst = "SELECT * FROM utilisateur WHERE email = ?";
$conn = $pdo->prepare($rqst);
$conn->execute([$email]);
$user = $conn->fetch();

//Verification
if($user)
{
    if (password_verify($passwd, $user["mdp_hash"]))
    {            
        $response =[
            'id'=>$user['id'],
            'nom'=>$user['nom'],
            'role'=>$user['role'],
            'email'=>$user['email']
        ];

        $_SESSION = $response;
        $_SESSION["logged"] =  true; 
        
        http_response_code(200);
        echo json_encode($response);
    }
    else
    {
        http_response_code(401);
        echo json_encode(["error" => "mot de passe incorrect"]);
    }
}
else
{
    http_response_code(404);
    echo json_encode(["error" => "utilisateur non existant"]);
}

?>