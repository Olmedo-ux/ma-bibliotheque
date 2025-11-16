<?php
session_start();
require 'config.php';

// Vérification de sécurité
if (!isset($_SESSION['lecteur_id'])) {
    header("Location: connexion.php");
    exit;
}

if (isset($_GET['book_id']) && !empty($_GET['book_id'])) {
    
    $book_id = $_GET['book_id'];
    $lecteur_id = $_SESSION['lecteur_id']; // Utilisation de l'ID de session

    // date de retour (l'heure actuelle)
    $sql = "UPDATE Liste_lecture 
            SET date_retour = NOW() 
            WHERE id_livre = ? 
            AND id_lecteur = ?
            AND date_retour IS NULL"; // mis à jour UNIQUEMENT l'emprunt actif
    
    $stmt = $conn->prepare($sql);

    try {
        $stmt->execute([$book_id, $lecteur_id]);

        // Redirection vers la liste de lecture
        header("Location: wishlist.php?status=removed");
        exit;

    } catch (PDOException $e) {
        echo "Erreur de mise à jour (retour) : " . $e->getMessage();
    }

} else {
    header("Location: wishlist.php?status=error");
}

$conn = null;
?>