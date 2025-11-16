<?php 
session_start(); 

// --- SÉCURITÉ : VÉRIFICATION DE L'AUTHENTIFICATION ---
// Si l'utilisateur n'est pas connecté rediriger.
$current_page = basename($_SERVER['PHP_SELF']);
$public_pages = ['connexion.php', 'inscription.php', 'config.php']; 

if (!isset($_SESSION['lecteur_id']) && !in_array($current_page, $public_pages)) {
    header("Location: connexion.php");
    exit;
}

// Utile pour passer le titre de la page
if (!isset($page_title)) {
    $page_title = "Bibliothèque Book Sanctuary";
}

// Récupération du prénom pour l'affichage (s'il est connecté)
$lecteur_prenom = isset($_SESSION['lecteur_prenom']) ? htmlspecialchars($_SESSION['lecteur_prenom']) : 'Visiteur';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($page_title); ?> - Bibliothèque Book Sanctuary</title>
<link rel="stylesheet" href="style.css?v=20241114"></head>
<body>
    <header>
        <div class="header-content">
            <h1>Bibliothèque Book Sanctuary</h1>
            <p>Le savoir à portée de clic</p>
        </div>
        
        <nav class="main-nav">
            <ul>
                <li><a href="index.php">Accueil</a></li>
                <li><a href="results.php">Catalogue</a></li>
                <li><a href="wishlist.php">Liste de Lecture</a></li>
                <li><a href="historique.php">Historique</a></li> <li><a href="admin_panel.php">Admin</a></li>
                
                <?php if (isset($_SESSION['lecteur_id'])): ?>
                    <li class="user-status">Bienvenue, <?php echo $lecteur_prenom; ?>!</li>
                    <li><a href="deconnexion.php">Déconnexion</a></li> <?php endif; ?>
            </ul>
        </nav>
    </header>
    
    <main>