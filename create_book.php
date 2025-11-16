<?php
$page_title = "Ajouter un Livre";
require 'config.php';
require 'header.php';
$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titre = htmlspecialchars($_POST['titre']);
    $auteur = htmlspecialchars($_POST['auteur']);
    $description = htmlspecialchars($_POST['description']);
    $maison_edition = htmlspecialchars($_POST['maison_edition']);
    $nombre_exemplaire = (int)$_POST['nombre_exemplaire'];
    $couverture = htmlspecialchars($_POST['couverture']); // Nouveau champ

    try {
        $sql = "INSERT INTO Livres (titre, auteur, description, maison_edition, nombre_exemplaire, couverture) 
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$titre, $auteur, $description, $maison_edition, $nombre_exemplaire, $couverture]);
        
        $message = "<p class='message success'>Livre '" . $titre . "' ajouté avec succès!</p>";

    } catch (PDOException $e) {
        $message = "<p class='message error'>Erreur lors de l'ajout du livre : " . $e->getMessage() . "</p>";
    }
}
$conn = null;
?>
<section class="admin-form">
    <h2>Ajouter un Nouveau Livre</h2>
    <?php echo $message; ?>
    <form action="create_book.php" method="POST">
        <label for="titre">Titre:</label>
        <input type="text" name="titre" required><br>
        
        <label for="auteur">Auteur:</label>
        <input type="text" name="auteur" required><br>
        
        <label for="description">Description:</label>
        <textarea name="description" rows="4"></textarea><br>
        
        <label for="maison_edition">Maison d'édition:</label>
        <input type="text" name="maison_edition"><br>
        
        <label for="nombre_exemplaire">Exemplaires:</label>
        <input type="number" name="nombre_exemplaire" required min="0"><br>

        <label for="couverture">Nom Fichier Couverture (ex: dune.jpg):</label>
        <input type="text" name="couverture" placeholder="Le nom du fichier dans le dossier /images/"><br>
        
        <button type="submit">Ajouter le Livre</button>
    </form>
    <div class="back-links">
        <a href="admin_panel.php">Retour au panneau admin</a>
    </div>
</section>

<?php require 'footer.php'; ?>