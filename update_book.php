<?php
$page_title = "Modifier un Livre";
require 'config.php';
require 'header.php';

$message = '';
$book = false;

if (!isset($_GET['id']) || empty($_GET['id'])) {
    // Rediriger si l'ID est manquant
    header("Location: admin_panel.php?status=error_id");
    exit;
}

$bookId = $_GET['id'];

// --- Partie 1 : Traitement de la soumission du formulaire (POST) ---
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titre = htmlspecialchars($_POST['titre']);
    $auteur = htmlspecialchars($_POST['auteur']);
    $description = htmlspecialchars($_POST['description']);
    $maison_edition = htmlspecialchars($_POST['maison_edition']);
    $nombre_exemplaire = (int)$_POST['nombre_exemplaire'];
    $couverture = htmlspecialchars($_POST['couverture']); // Nouveau champ
    
    try {
        $sql = "UPDATE Livres SET titre=?, auteur=?, description=?, maison_edition=?, nombre_exemplaire=?, couverture=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$titre, $auteur, $description, $maison_edition, $nombre_exemplaire, $couverture, $bookId]);
        
        // Rediriger pour éviter la re-soumission du formulaire
        header("Location: update_book.php?id=$bookId&status=updated");
        exit;

    } catch (PDOException $e) {
        $message = "<p class='message error'>Erreur lors de la mise à jour : " . $e->getMessage() . "</p>";
    }
}

try {
    $stmt = $conn->prepare("SELECT * FROM Livres WHERE id = ?");
    $stmt->execute([$bookId]);
    $book = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$book) {
        die("<section class='admin-form'>Livre non trouvé.</section>");
    }
} catch (PDOException $e) {
    die("Erreur de base de données : " . $e->getMessage());
}
$conn = null;
?>
<section class="admin-form">
    <h2>Modifier le Livre: <?php echo htmlspecialchars($book['titre']); ?></h2>
    <?php 
    if(isset($_GET['status']) && $_GET['status'] == 'updated') {
        echo "<p class='message success'>Livre mis à jour avec succès!</p>";
    }
    echo $message; 
    ?>
    <form action="update_book.php?id=<?php echo $bookId; ?>" method="POST">
        <label for="titre">Titre:</label>
        <input type="text" name="titre" value="<?php echo htmlspecialchars($book['titre']); ?>" required><br>
        
        <label for="auteur">Auteur:</label>
        <input type="text" name="auteur" value="<?php echo htmlspecialchars($book['auteur']); ?>" required><br>
        
        <label for="description">Description:</label>
        <textarea name="description" rows="4"><?php echo htmlspecialchars($book['description']); ?></textarea><br>
        
        <label for="maison_edition">Maison d'édition:</label>
        <input type="text" name="maison_edition" value="<?php echo htmlspecialchars($book['maison_edition']); ?>"><br>
        
        <label for="nombre_exemplaire">Exemplaires:</label>
        <input type="number" name="nombre_exemplaire" value="<?php echo htmlspecialchars($book['nombre_exemplaire']); ?>" required min="0"><br>

        <label for="couverture">Nom Fichier Couverture (ex: dune.jpg):</label>
        <input type="text" name="couverture" value="<?php echo htmlspecialchars($book['couverture']); ?>" placeholder="Le nom du fichier dans le dossier /images/"><br>
        
        <button type="submit">Enregistrer</button>
    </form>
    <div class="back-links">
        <a href="admin_panel.php">admin</a>
    </div>
</section>

<?php require 'footer.php'; ?>