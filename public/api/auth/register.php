<?php


/**
 * API — REGISTER
 * Méthode : POST
 *
 */

    require("../../../config/db.php");
    header("Content-Type: application/json");
    session_start();

    $data = json_decode(file_get_contents("php://input"), true);

    $email = $data["email"] ?? null;
    $nom = $data["nom"] ?? null;
    $passwd = $data['password'] ?? null;

    $rqst = "SELECT email FROM utilisateur WHERE email=?";
    $conn = $pdo->prepare($rqst);
    $conn->execute([$email]);
    $user = $conn->fetch();

    if($user)
    {
        http_response_code(409);
        echo json_encode(["error"=>"email existant"]);
    }
    else
    {
        $passwd = password_hash($passwd, PASSWORD_BCRYPT);
        $rqst = "INSERT INTO utilisateur(nom, mdp_hash, email) VALUES (?, ?, ?)";
        $conn = $pdo->prepare($rqst);
        $success = $conn->execute([$nom, $passwd, $email]);
        
        if($success)
        {
            http_response_code(201);
            echo json_encode(["message" => "utilisateur crée"]);
        }
    }

    exit;



?>