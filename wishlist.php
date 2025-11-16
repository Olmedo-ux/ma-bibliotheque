<?php 
$page_title = "Ma Liste de Lecture Active";
require 'config.php';
require 'header.php'; //vérifier la connexion
?>

<section class="wishlist-page">
    <h2>Liste de Lecture</h2>

    <?php
    // Gérer les messages de statut
    if (isset($_GET['status'])) {
        if ($_GET['status'] == 'success') {
            echo "<p class='message success'>Livre ajouté à votre liste !</p>";
        }
        if ($_GET['status'] == 'removed') {
            echo "<p class='message success'>Livre retiré de votre liste (ajouté à l'historique).</p>";
        }
    }
    
    $lecteur_id = $_SESSION['lecteur_id']; // Utilisation de l'ID de session
    
    // Requête SQL pour obtenir les détails des livres EN COURS (date_retour IS NULL)
    $sql = "SELECT L.id, L.titre, L.auteur, L.couverture
            FROM Livres AS L
            JOIN Liste_lecture AS LL ON L.id = LL.id_livre
            WHERE LL.id_lecteur = ? AND LL.date_retour IS NULL";
    
    $stmt = $conn->prepare($sql);
    $stmt->execute([$lecteur_id]);

    if ($stmt->rowCount() > 0) {
        echo "<ul class='wishlist-ul'>";
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<li class='wishlist-item result-with-cover'>";
            
            // Miniature de couverture
            if (!empty($row['couverture'])) {
                echo "<img src='images/" . htmlspecialchars($row['couverture']) . "' alt='Couverture' class='result-cover-thumb'>";
            }
            
            echo "<div class='item-info'>";
            echo "<strong>" . htmlspecialchars($row['titre']) . "</strong> par " . htmlspecialchars($row['auteur']);
            echo "</div>";

            // Bouton Retirer
            echo "<a href='remove_from_wishlist.php?book_id=" . $row['id'] . "' class='btn-remove'>Rendre / Retirer</a>";
            
            echo "</li>";
        }
        echo "</ul>";
    } else {
        echo "<p>Votre liste de lecture active est vide pour le moment. Trouvez votre prochaine lecture !</p>";
    }

    $conn = null;
    ?>
    <div class="back-links">
        <a href="results.php">Catalogue</a>
        <a href="historique.php">Historique</a>
    </div>
</section>

<?php require 'footer.php'; ?>