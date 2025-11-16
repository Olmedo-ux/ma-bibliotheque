<?php 
$page_title = "Mon Historique de Lecture";
require 'config.php';
require 'header.php'; //vérifie la connexion

$stmt = null; 
$historique_found = false;

// Sécurité 
if (isset($_SESSION['lecteur_id'])) {
    $lecteur_id = $_SESSION['lecteur_id'];
    
    // Requête SQL pour afficher l'historique COMPLET
    $sql = "SELECT 
                L.titre, 
                L.auteur, 
                LL.date_emprunt, 
                LL.date_retour
            FROM Liste_lecture AS LL
            JOIN Livres AS L ON LL.id_livre = L.id
            WHERE LL.id_lecteur = ?
            ORDER BY LL.date_emprunt DESC"; // Afficher les plus récents en premier
    
    try {
        $stmt = $conn->prepare($sql);
        $stmt->execute([$lecteur_id]);
        
        if ($stmt->rowCount() > 0) {
            $historique_found = true;
        }
        
    } catch (PDOException $e) {
        // En cas d'erreur SQL afficher un message d'erreur
        echo "<p class='message error'>Erreur lors du chargement de l'historique : " . $e->getMessage() . "</p>";
    }
}
// --- FIN LOGIQUE DE REQUÊTE ---
?>

<section class="wishlist-page">
    <h2>Historique</h2>

    <?php
    if ($historique_found) {
        
        echo "<table class='data-table'>";
        echo "<thead><tr><th>Titre</th><th>Auteur</th><th>Date d'Emprunt</th><th>Date de Retour</th></tr></thead>";
        echo "<tbody>";
        
        // La boucle utilise l'objet $stmt qui est garanti d'être défini
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            // Formatage de l'affichage de la date de retour (ou "En cours...")
            $date_retour = $row['date_retour'] ? date('Y-m-d H:i:s', strtotime($row['date_retour'])) : '<span class="status-active">En cours...</span>';

            echo "<tr>";
            // Ajout des data-label pour le style responsive
            echo "<td data-label=\"Titre\">" . htmlspecialchars($row['titre']) . "</td>";
            echo "<td data-label=\"Auteur\">" . htmlspecialchars($row['auteur']) . "</td>";
            echo "<td data-label=\"Date d'Emprunt\">" . htmlspecialchars($row['date_emprunt']) . "</td>";
            echo "<td data-label=\"Date de Retour\">" . $date_retour . "</td>";
            echo "</tr>";
        }
        
        echo "</tbody>";
        echo "</table>";
    } else {
        echo "<p>Aucun historique de lecture trouvé.</p>";
    }

    $conn = null;
    ?>
    <div class="back-links">
        <a href="wishlist.php">Liste</a>
    </div>
</section>

<?php require 'footer.php'; ?>