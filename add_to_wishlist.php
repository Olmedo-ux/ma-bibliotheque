<?php
session_start(); 
require 'config.php';

// Vérification de sécurité
if (!isset($_SESSION['lecteur_id']) || $_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: connexion.php");
    exit;
}

$book_id = $_POST['book_id'];
$lecteur_id = $_SESSION['lecteur_id']; // Utilisation de l'ID de session

// MODIFICATION : Insertion de la date d'emprunt avec NOW() et date_retour à NULL
$sql = "INSERT INTO Liste_lecture (id_livre, id_lecteur, date_emprunt, date_retour) VALUES (?, ?, NOW(), NULL)";

$stmt = $conn->prepare($sql);

try {
    $stmt->execute([$book_id, $lecteur_id]);

    // Redirection vers la liste de lecture avec succès
    header("Location: wishlist.php?status=success");
    exit;

} catch (PDOException $e) {
    // Erreur : livre déjà dans la liste (code 23000)
    if ($e->getCode() == 23000) {
        header("Location: details.php?id=$book_id&status=already_added");
    } else {
        // Autre erreur
        echo "Erreur : " . $e->getMessage();
    }
}

$conn = null;
?>