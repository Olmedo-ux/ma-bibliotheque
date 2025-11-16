<?php 
$page_title = "Détails du Livre";
require 'config.php';
require 'header.php'; // header.php démarre la session et vérifie la connexion

$book_in_wishlist = false;

if (isset($_GET['id']) && !empty($_GET['id'])) {
    
    $bookId = $_GET['id'];
    
    // 1. Récupération des détails du livre
    $stmt = $conn->prepare("SELECT * FROM Livres WHERE id = ?");
    $stmt->execute([$bookId]);

    if ($stmt->rowCount() > 0) {
        $book = $stmt->fetch(PDO::FETCH_ASSOC);

        // 2. Vérification si le livre est DÉJÀ dans la liste de lecture ACTIVE
        // MODIFICATION ICI : Utilisation de id_livre au lieu de id pour la sélection.
        $check_sql = "SELECT id_livre FROM Liste_lecture WHERE id_livre = ? AND id_lecteur = ? AND date_retour IS NULL";
        $check_stmt = $conn->prepare($check_sql);
        $check_stmt->execute([$bookId, $_SESSION['lecteur_id']]);
        
        if ($check_stmt->rowCount() > 0) {
            $book_in_wishlist = true;
        }

        // ... suite de l'affichage ...
?>

<section class="book-details-page">
    <?php
    if (isset($_GET['status'])) {
        if ($_GET['status'] == 'already_added') {
            echo "<p class='message error'>Livre déjà dans votre liste de lecture.</p>";
        }
    }
    ?>

    <div class='book-flex-container'>
        <?php if (!empty($book['couverture'])): ?>
            <div class='book-cover-container'>
                <img src='images/<?php echo htmlspecialchars($book['couverture']); ?>' alt='Couverture de <?php echo htmlspecialchars($book['titre']); ?>' class='book-cover-img'>
            </div>
        <?php endif; ?>

        <div class='book-info-text'>
            <h2><?php echo htmlspecialchars($book['titre']); ?></h2>
            <p><strong>Auteur :</strong> <?php echo htmlspecialchars($book['auteur']); ?></p>
            <p><strong>Maison d'édition :</strong> <?php echo htmlspecialchars($book['maison_edition']); ?></p>
            <p><strong>Exemplaires disponibles :</strong> <?php echo htmlspecialchars($book['nombre_exemplaire']); ?></p>
            
            <div class='description'>
                <h3>Description</h3>
                <p><?php echo nl2br(htmlspecialchars($book['description'])); ?></p>
            </div>

            <?php if (!$book_in_wishlist): ?>
                <form action='add_to_wishlist.php' method='POST'>
                    <input type='hidden' name='book_id' value='<?php echo $book['id']; ?>'>
                    <input type='hidden' name='lecteur_id' value='<?php echo $_SESSION['lecteur_id']; ?>'> 
                    <button type='submit' class="btn-primary">Ajouter à ma liste de lecture</button>
                </form>
            <?php else: ?>
                <p class='message success'>Ce livre est dans votre <a href='wishlist.php'>liste de lecture</a>.</p>
            <?php endif; ?>

        </div> </div> <?php 
    } else {
        echo "<p>Ce livre n'a pas été trouvé.</p>";
    }

} else {
    echo "<p>Aucun livre sélectionné.</p>";
}

$conn = null;
?>
</section>

<?php require 'footer.php'; ?>