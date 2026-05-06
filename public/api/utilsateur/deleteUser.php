<?php
/**
 * API — Supprimer un utilisateur
 * Méthode : DELETE
 *
 * Par ID    →  DELETE /deleteUser.php?id=5
 * Par email →  DELETE /deleteUser.php?email=user@exemail.com
 *
 * Suppression douce (soft delete) si la colonne `deleted_at` existe.
 * Suppression définitive sinon.
 */


if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

require_once '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'DELETE') 
{
    http_response_code(405);
    echo json_encode(["success" => false, "message" => "Méthode non autorisée"]);
    exit();
}

// ── Lecture des paramètres (query string ou body JSON) ────
parse_str(file_get_contents("php://input"), $body);
$params_all = array_merge($_GET, $body ?? []);

$id    = isset($params_all['id'])    ? filter_var($params_all['id'], FILTER_VALIDATE_INT) : null;
$email = isset($params_all['email']) ? trim(strtolower($params_all['email']))              : null;

if (!$id && !$email) {
    http_response_code(400);
    echo json_encode(["success" => false, "message" => "Paramètre requis manquant : fournissez 'id' ou 'email'."]);
    exit();
}

// ── Validation ────────────────────────────────────────────
if ($id !== null && ($id === false || $id <= 0)) {
    http_response_code(400);
    echo json_encode(["success" => false, "message" => "ID invalide."]);
    exit();
}

if ($email !== null && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode(["success" => false, "message" => "Adresse email invalide."]);
    exit();
}


try {
    if ($id) {
        $stmt = $pdo->prepare ("SELECT id, nom, prenom, email, role FROM utilisateurs WHERE id = :val LIMIT 1");
        $stmt->execute([':val' => $id]);
    } else {
        $stmt = $pdo->prepare ("SELECT id, nom, prenom, email, role FROM utilisateurs WHERE email = :val LIMIT 1");
        $stmt->execute([':val' => $email]);
    }

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        http_response_code(404);
        echo json_encode(["success" => false, "message" => "Utilisateur introuvable."]);
        exit();
    }

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["success" => false, "message" => "Erreur serveur lors de la recherche de l'utilisateur."]);
    exit();
}

// ── Protection : empêcher la suppression du dernier admin ─
if ($user['role'] === 'admin') {
    try {
        $check = $pdo->query ("SELECT COUNT(*) FROM utilisateurs WHERE role = 'admin'");
        $admin_count = (int) $check->fetchColumn();

        if ($admin_count <= 1) {
            http_response_code(403);
            echo json_encode([
                "success" => false,
                "message" => "Impossible de supprimer le dernier administrateur."
            ]);
            exit();
        }
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(["success" => false, "message" => "Erreur serveur lors de la vérification des droits."]);
        exit();
    }
}

// ── Détection soft delete (colonne deleted_at) ────────────
$soft_delete = false;

try {
    $cols = $pdo->query("SHOW COLUMNS FROM utilisateurs LIKE 'deleted_at'");
    if ($cols->rowCount() > 0) {
        $soft_delete = true;
    }
} catch (PDOException $e) {
    // Colonne absente → suppression définitive
}

// ── Suppression ───────────────────────────────────────────
try {
    if ($soft_delete) {
        // Soft delete : marquer la date de suppression
        $del = $pdo->prepare("UPDATE utilisateurs SET deleted_at = NOW() WHERE id = :id");
        $del->execute([':id' => $user['id']]);
        $type = "désactivé (soft delete)";
    } else {
        // Hard delete
        $del = $pdo->prepare("DELETE FROM utilisateurs WHERE id = :id");
        $del->execute([':id' => $user['id']]);
        $type = "supprimé définitivement";
    }

    http_response_code(200);
    echo json_encode([
        "success" => true,
        "message" => "Utilisateur $type avec succès.",
        "utilisateur_supprime" => [
            "id"     => $user['id'],
            "nom"    => $user['nom'],
            "prenom" => $user['prenom'],
            "email"  => $user['email'],
        ]
    ]);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["success" => false, "message" => "Erreur serveur lors de la suppression de l'utilisateur."]);
}