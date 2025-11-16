<?php 
$page_title = "Accueil"; 
require 'config.php'; // Connexion à la base de données
require 'header.php'; 
?>

<section class="welcome">
    <h2>Bienvenue sur notre Bibliothèque Numérique Book Sanctuary !</h2>
    <p>Recherchez votre prochaine lecture parmi notre vaste catalogue.</p>
</section>

<section class="search">
    <h3>Rechercher un livre</h3>
    <form action="results.php" method="GET">
        <input type="text" name="query" placeholder="Titre ou Auteur du livre" required> 
        <button type="submit">Rechercher</button>
    </form>
</section>

---

<section class="latest-books">
    <h2>Nouveautés</h2>
    
    <?php
    // Requête pour sélectionner les 6 derniers livres ajoutés
    $sql = "SELECT id, titre, auteur, couverture FROM Livres ORDER BY id DESC LIMIT 6";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        echo "<div class='results-grid'>"; 
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            
            // Affichage de chaque livre dans une grille
            echo "<article class='book-result result-with-cover'>";
            
            // Miniature de couverture
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
        echo "</div>"; // Fin results-grid
    } else {
        echo "<p>Aucun livre disponible.</p>";
    }

    $conn = null;
    ?>
</section>

<?php 
require 'footer.php'; 
?>