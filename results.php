<?php 
$page_title = "Résultats de la Recherche";
require 'config.php';
require 'header.php'; 
?>

<section class="results-page">
    <?php
    $searchTerm = isset($_GET['query']) ? $_GET['query'] : '';
    
    if (!empty($searchTerm)) {
        echo "<h2>Résultats pour : \"" . htmlspecialchars($searchTerm) . "\"</h2>";
        $sql = "SELECT id, titre, auteur, couverture FROM Livres WHERE titre LIKE ? OR auteur LIKE ?";
        $searchPattern = "%" . $searchTerm . "%";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$searchPattern, $searchPattern]);
    } else {
        echo "<h2>Catalogue Complet</h2>";
        $sql = "SELECT id, titre, auteur, couverture FROM Livres";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
    }

    if ($stmt->rowCount() > 0) {
        echo "<div class='results-grid'>"; 
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            
            echo "<article class='book-result result-with-cover'>";
            
            // Affichage de la miniature
            if (!empty($row['couverture'])) {
                echo "<img src='images/" . htmlspecialchars($row['couverture']) . "' alt='Couverture de " . htmlspecialchars($row['titre']) . "' class='result-cover-thumb'>";
            }
            
            echo "<div class='result-text'>";
            echo "<h3>" . htmlspecialchars($row['titre']) . "</h3>";
            echo "<p>Par : " . htmlspecialchars($row['auteur']) . "</p>";
            echo "<a href='details.php?id=" . $row['id'] . "' class='btn-details'>Voir les détails</a>";
            echo "</div>"; 
            
            echo "</article>";
        }
        echo "</div>"; 
    } else {
        echo "<p>Aucun livre trouvé.</p>";
    }

    $conn = null;
    ?>
</section>

<?php require 'footer.php'; ?>