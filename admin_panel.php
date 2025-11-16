<?php 
$page_title = "Admin";
require 'config.php';
require 'header.php'; 
?>

<section class="admin-panel">
    <h2>Gestion des Livres</h2>

    <?php
    // Affichage des messages de statut
    if (isset($_GET['status'])) {
        if ($_GET['status'] == 'deleted') {
            echo "<p class='message success'>Livre supprimé avec succès.</p>";
        }
        if ($_GET['status'] == 'error_delete') {
            echo "<p class='message error'>Erreur : Impossible de supprimer le livre (peut être lié par d'autres tables).</p>";
        }
    }
    ?>

    <p>Bienvenue admin. Vous pouvez gérer le catalogue de la bibliothèque.</p>
    
    <div class="admin-actions">
        <a href="create_book.php" class="btn-primary">➕ Ajouter un Nouveau Livre</a>
    </div>

    <h3>Catalogue</h3>
    <?php
    // Afficher la liste des livres pour modification/suppression
    $stmt = $conn->prepare("SELECT id, titre, auteur FROM Livres ORDER BY titre");
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        echo "<ul class='admin-list'>";
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<li class='admin-list-item'>";
            echo "<span><strong>" . htmlspecialchars($row['titre']) . "</strong> par " . htmlspecialchars($row['auteur']) . "</span>";
            echo "<div class='actions'>";
            echo "<a href='update_book.php?id=" . $row['id'] . "' class='btn-details'>Modifier</a>";
            // Confirmation JavaScript avant la suppression
            echo "<a href='delete_book.php?id=" . $row['id'] . "' class='btn-remove' onclick=\"return confirm('Êtes-vous sûr de vouloir supprimer ce livre ?');\">Supprimer</a>";
            echo "</div>";
            echo "</li>";
        }
        echo "</ul>";
    } else {
        echo "<p>Aucun livre dans le catalogue. Veuillez en ajouter un.</p>";
    }
    $conn = null;
    ?>
</section>

<?php require 'footer.php'; ?>