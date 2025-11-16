<?php
$page_title = "Inscription";
require 'config.php';
$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = htmlspecialchars($_POST['nom']);
    $prenom = htmlspecialchars($_POST['prenom']);
    $email = htmlspecialchars($_POST['email']);
    $password = $_POST['password'];

    // Hachage sécurisé du mot de passe
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    try {
        $sql = "INSERT INTO Lecteurs (nom, prenom, email, mot_de_passe) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$nom, $prenom, $email, $hashed_password]);
        
        $message = "<p class='message success'>Inscription réussie ! Vous pouvez maintenant vous <a href='connexion.php'>connecter</a>.</p>";

    } catch (PDOException $e) {
        if ($e->getCode() == 23000) { // Code pour violation de contrainte unique (email déjà utilisé)
            $message = "<p class='message error'>Cet email est déjà utilisé.</p>";
        } else {
            $message = "<p class='message error'>Erreur lors de l'inscription: " . $e->getMessage() . "</p>";
        }
    }
}
$conn = null;

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($page_title); ?> -Bibliothèque Book Sanctuary </title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <main class="login-register-page"> 

    <section class="admin-form">
        <h2>Inscription</h2>
        <?php echo $message; ?>
        <form action="inscription.php" method="POST">
            <label for="prenom">Prénom:</label>
            <input type="text" name="prenom" required><br>

            <label for="nom">Nom:</label>
            <input type="text" name="nom" required><br>
            
            <label for="email">Email:</label>
            <input type="email" name="email" required><br>
            
            <label for="password">Mot de passe:</label>
            <input type="password" name="password" required><br>
            
            <button type="submit" class="btn-primary">S'inscrire</button>
        </form>
        <p>Déjà membre? <a href="connexion.php">Se connecter</a></p>
    </section>

    </main>
</body>
</html>